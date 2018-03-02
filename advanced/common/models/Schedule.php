<?php
namespace common\models;


use yii\db\ActiveQuery;
use common\publics\MyHelper;
use backend\models\PublishCate;

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
			['title','required','message'=>'课表主题不能为空','on'=>['add','edit']],
			[['gradeClassId','gradeClass'],'required','message'=>'授课班级不能为空','on'=>['add','edit']],
			['publishCode','required','message'=>'请选择发布类型','on'=>'publish'],
			['publishEndTime','required','message'=>'发布结束时间不能为空','on'=>'publish'],
		    [['search','isPublish','publishEndTime','marks','publishCode','publishTime'],'safe'],
		];
	}
	
	public function add(array $data)
	{
	    $this->scenario = 'add';
	    if($this->load($data) && $this->validate()){
	        $this->publishEndTime= strtotime($this->publishEndTime);
	        PublishCate::getPublishTime($this->publishCode,$this);
	        return $this->save(false);
	    }
	    return false;
	}
	
	public static function edit(array $data,Schedule $schedule,$scenario = 'edit')
	{
		$schedule->scenario = $scenario;
	    if($schedule->load($data) && $schedule->validate()){
	        $schedule->publishEndTime= strtotime($schedule->publishEndTime);
	        PublishCate::getPublishTime($schedule->publishCode,$schedule);
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
	
	public function getTables()
	{
	    return $this->hasMany(ScheduleTable::className(), ['scheduleId'=>'id']);
	}
	
	public function pageList(array $data)
	{
	    $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
	    $scheduleListQuery = self::find()
    	    ->select([
    	        'id',
    	        'title',
    	        'gradeClass',
    	        'gradeClassId',
    	        'isPublish',
    	        'publishTime',
    	        'publishEndTime',
    	        'createTime',
    	        'modifyTime'
    	    ])
    	    ->where([self::tableName().'.isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
		if($this->load($data) && !empty($this->search)){
			$scheduleListQuery = $this->filterSearch($this->search,$scheduleListQuery);
		}
		$result = $this->query($scheduleListQuery, $this->curPage, $this->pageSize);
		return $result;
	}
	
	public function export(array $data)
	{
	    $query = self::find()
	    ->select([
	        self::tableName().'.id',
	        self::tableName().'.title',
	        self::tableName().'.gradeClass',
	        self::tableName().'.isPublish',
	        self::tableName().'.publishTime',
	        self::tableName().'.marks',

	    ])
	    ->joinWith('tables')
	    ->where([self::tableName().'.isDelete'=>self::CURRICULUM_UNDELETE])->orderBy(self::tableName().'.modifyTime DESC,'.ScheduleTable::tableName().'.lessonDate ASC,'.ScheduleTable::tableName().'.lessonStartTime ASC');
	    if($this->load($data) && !empty($this->search)){
	        $query= $this->filterSearch($this->search,$query);
	    }
	    $result = $query->asArray()->limit(1000)->all();
	    if(empty($result)){
	        return false;
	    }
	    
	    $phpExcel = new \PHPExcel();
	    $objSheet = $phpExcel->getActiveSheet();
	    $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $objSheet->setTitle('课表列表');
	    
	    //设置行高
	    $objSheet->getDefaultRowDimension()->setRowHeight(24);
	    
	    //内容宽度
	    $objSheet->getColumnDimension('A')->setWidth(50);
	    $objSheet->getColumnDimension('B')->setWidth(40);
	    $objSheet->getColumnDimension('C')->setWidth(40);
	    $objSheet->getColumnDimension('D')->setWidth(30);
	    
	    //tables  4列
	    $index = 1;
	    foreach ($result as $val){
	        $objSheet->mergeCells('A'.$index.':D'.$index)->setCellValue('A'.$index,$val['title'].'【'.$val['gradeClass'].'】');
	        //设置课表标题样式
	        $titleStyle = $objSheet->getStyle('A'.$index.':D'.$index);
	        $titleStyle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
	        $titleStyle->getFill()->getStartColor()->setARGB('61aeec');
	        $titleStyle->getFont()->setBold(true);
	        $titleStyle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
	        $titleStyle->getFont()->setSize(14);
	        $index ++;
	        $objSheet->setCellValue('A'.$index,'课程名称')->setCellValue('B'.$index,'授课时间')->setCellValue('C'.$index,'授课地点')->setCellValue('D'.$index,'授课教师');
	        $titleStyle = $objSheet->getStyle('A'.$index.':D'.$index);
	        $titleStyle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
	        $titleStyle->getFill()->getStartColor()->setARGB('f3f3f3');
	        $titleStyle->getFont()->setBold(true);
	        $titleStyle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_BLACK);
	        $titleStyle->getFont()->setSize(12);
	        $index ++;
	        if(empty($val['tables'])){
	            $objSheet->mergeCells('A'.$index.':D'.$index)->setCellValue('A'.$index,'暂时未安排课程');
	            $index++;
	        }else{
    	        foreach ($val['tables'] as $v){
    	            $objSheet->setCellValue('A'.$index,$v['curriculumText'])->setCellValue('B'.$index,$v['lessonDate'].' '.$v['lessonStartTime'].'~'.$v['lessonEndTime'])->setCellValue('C'.$index,$v['teachPlace'])->setCellValue('D'.$index,$v['teacherName']);
    	            $index++;
    	        }
	        }
	        $index++;
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
			$query= $query->andWhere(['like','gradeClass',trim($search['gradeClass'])]);
		}
		
		if(isset($search['title']) && !empty($search['title'])){
			$query= $query->andWhere(['like','title',trim($search['title'])]);
		}
		
		if(!empty($search['startTime'])){
			$query = $query->andWhere('lessonDate >= :startTime',[':startTime'=>$search['startTime']]);
		}
		if(!empty($search['endTime'])){
			$query = $query->andWhere('lessonDate <= :endTime',[':endTime'=>$search['endTime']]);
		}
		
		if(isset($search['isPublish']) && !empty($search['isPublish'])){
			$query= $query->andWhere(['isPublish'=>$search['isPublish']]);
		}
		
		if(isset($search['isDelete']) && !empty($search['isDelete'])){
			$query= $query->andWhere(['isDelete'=>$search['isDelete']]);
		}
		return $query;
	}
}