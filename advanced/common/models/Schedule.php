<?php
namespace common\models;


use yii\db\ActiveQuery;
use common\publics\MyHelper;

/**
 * 课表
 * @author wangtao
 *
 */
class Schedule extends BaseModel
{
	const CURRICULUM_DELETE = 1;
	
	const CURRICULUM_UNDELETE = 0;
	
	
	public static function tableName()
	{
		return '{{%Schedule}}';
	}
	
	public function rules()
	{
		return [
			[['curriculumId','curriculumText'],'required','message'=>'课程不能为空','on'=>['add','edit']],
		    [['teacherId','teacherName'],'required','message'=>'授课教师不能为空','on'=>['add','edit']],
		    [['teachPlaceId','teachPlace'],'required','message'=>'教学地点不能为空','on'=>['add','edit']],
		    [['gradeClassId','gradeClass'],'required','message'=>'授课班级不能为空','on'=>['add','edit']],
		    [['lessonDate','lessonStartTime','lessonEndTime'],'required','message'=>'上课时间不能为空','on'=>['add','edit']],
		    [['search','isPublish','publishTitle','publishEndDate','marks'],'safe'],
		];
	}
	
	public function add(array $data)
	{
	    $this->scenario = 'add';
	    if($this->load($data) && $this->validate()){
	        return $this->save(false);
	    }
	    return false;
	}
	
	public static function edit(array $data,Schedule $schedule)
	{
	    $schedule->scenario = 'edit';
	    if($schedule->load($data) && $schedule->validate()){
	        return $schedule->save(false);
	    }
	    return false;
	}
	
	public static function del(Schedule $schedule)
	{
	    $schedule->isDelete = 1;
	    return $schedule->save(false);
	}
	
	public function getTeachplaces()
	{
		return $this->hasOne(TeachPlace::className(), ['id'=>'teachPlaceId']);
	}
	
	public function getGradeclass()
	{
		return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
	}
	
	public function pageList(array $data)
	{
	    $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
	    $scheduleListQuery = self::find()
    	    ->select([])
    	    //->joinWith('teachplaces')
    	    //->joinWith('gradeclass')
    	    ->where([self::tableName().'.isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
		if($this->load($data)){
			$scheduleListQuery = $this->filterSearch($this->search,$scheduleListQuery);
		}
		$result = $this->query($scheduleListQuery, $this->curPage, $this->pageSize);
		return $result;
	}
	
	public function export(array $data)
	{
	    $query = self::find()
	    ->select([])
	    //->joinWith('teachplaces')
	    //->joinWith('gradeclass')
	    ->where([self::tableName().'.isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
	    if($this->load($data)){
	        $query= $this->filterSearch($this->search,$query);
	    }
	    $result = $query->asArray()->all();
	    
	    $phpExcel = new \PHPExcel();
	    $objSheet = $phpExcel->getActiveSheet();
	    $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $objSheet->setTitle('课表列表');
	    $objSheet->setCellValue('A1','序号')->setCellValue('B1','授课班级')->setCellValue('C1','课程名称')->setCellValue('D1','上课时间')
	    ->setCellValue('E1','授课教师')->setCellValue('F1','授课地点')->setCellValue('G1','是否发布')
	    ->setCellValue('H1','创建时间')->setCellValue('I1','修改时间');
	    $num  = 2;
	    foreach ($result as $val){
	        $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['gradeClass'])->setCellValue('C'.$num,$val['curriculumText'])->setCellValue('D'.$num,$val['lessonDate'] . ' ' . $val['lessonStartTime'] . '~' . $val['lessonEndTime'])
	        ->setCellValue('E'.$num,$val['teacherName'])->setCellValue('F'.$num,$val['teachPlace'])->setCellValue('G'.$num,$val['isPublish'] == 1?'已发布':'未发布')
	        ->setCellValue('H'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('I'.$num,MyHelper::timestampToDate($val['modifyTime']));
	        $num ++;
	    }
	    $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
	    ExcelMolde::exportBrowser('课表列表.xlsx');
	    $objWriter->save('php://output');
	}
	
	public function filterSearch($search,ActiveQuery $query) {
		if(!isset($search) || empty($search)){
			return $query;
		}
		if(isset($search['gradeClassId']) && !empty($search['gradeClassId'])){
			$query= $query->andWhere(['gradeClassId'=>$search['gradeClassId']]);
		}
		if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
			$query= $query->andWhere(['like','gradeClass',$search['gradeClass']]);
		}
		if(isset($search['curriculumId']) && !empty($search['curriculumId'])){
			$query= $query->andWhere(['curriculumId'=>$search['curriculumId']]);
		}
		if(isset($search['curriculumText']) && !empty($search['curriculumText'])){
			$query= $query->andWhere(['like','curriculumText',$search['curriculumText']]);
		}
		if(isset($search['teacherId']) && !empty($search['teacherId'])){
			$query= $query->andWhere(['teacherId'=>$search['teacherId']]);
		}
		if(isset($search['teacherName']) && !empty($search['teacherName'])){
			$query= $query->andWhere(['like','teacherName',$search['teacherName']]);
		}
		if(isset($search['teachPlaceId']) && !empty($search['teachPlaceId'])){
			$query= $query->andWhere(['teachPlaceId'=>$search['teachPlaceId']]);
		}
		if(isset($search['teachPlace']) && !empty($search['teachPlace'])){
			$query= $query->andWhere(['like','teachPlace',$search['teachPlace']]);
		}
		if(!empty($search['startTime'])){
			$query = $query->andWhere('lessonDate >= :startTime',[':startTime'=>$search['startTime']]);
		}
		if(!empty($search['endTime'])){
			$query = $query->andWhere('lessonDate <= :endTime',[':endTime'=>$search['endTime']]);
		}
		return $query;
	}
}