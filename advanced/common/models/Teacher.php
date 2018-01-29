<?php
namespace common\models;


use yii\db\ActiveQuery;
use common\publics\MyHelper;

/**
 * 教师
 * @author wangtao
 *
 */
class Teacher extends BaseModel
{
	const TEACHER_DELETE = 1;
	
	const TEACHER_UNDELETE = 0;
	
	public static function tableName()
	{
		return '{{%Teacher}}';
	}
	
	public function rules()
	{
		return [
		    ['trueName','required','message'=>'教师名称不能为空','on'=>['create','edit']],
		    ['trueName', 'string', 'length' => [2, 20], 'tooLong'=>'教师名称长度为4-40个字符', 'tooShort'=>'教师名称长度为2-20个字','on'=>['create','edite']],
		    ['sex', 'in', 'range' => [1, 2],'message'=>'性别无效','on'=>['create','edit']],
		    ['sex','default','value'=>1,'on'=>['create','edit']],
		    ['positionalTitles','required','message'=>'教师职称不能为空','on'=>['create','edit']],
		    ['positionalTitles', 'string', 'length' => [2, 50], 'tooLong'=>'教师职称描述长度为4-100个字符', 'tooShort'=>'教师职称描述长度为2-50个字','on'=>['create','edite']],
		    ['phone','required','message'=>'教师手机号不能为空','on'=>['create','edit']],
		    ['phone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'教师手机号必须有效','on'=>['create','edit']],
				
			['duties','required','message'=>'教师行政职务不能为空','on'=>['create','edit']],
			['from','required','message'=>'教师来源情况不能为空','on'=>['create','edit']],
			['teachTopics','required','message'=>'教师授课专题不能为空','on'=>['create','edit']],
		    [['sex','createAdminId','curPage','pageSize','search','studyField'],'safe'],
		];
	}
	
	public function create(array $data)
	{
	    $this->scenario = 'create';
	    if($this->load($data) && $this->validate() && $this->save(false)){
	        return true;
	    }
	    return false;
	}
	
	public static function edit(array $data , Teacher $teacher)
	{
	    $teacher->scenario = 'edit';
	    if($teacher->load($data) && $teacher->validate() && $teacher->save(false)){
	        return true;
	    }
	    return false;
	}
	
	public static function del(int $id,Teacher $teacher)
	{
	    $teacher->isDelete = self::TEACHER_DELETE;
	    return $teacher->save(false);
	}
	
	public function pageList(array $data)
	{
	    $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
	    $teacherListQuery = self::find()->select([])->where(['isDelete'=>self::TEACHER_UNDELETE])->orderBy('createTime desc,modifyTime desc');
		if($this->load($data)){
			$teacherListQuery = $this->filterSearch($this->search, $teacherListQuery);
		}
		$result = $this->query($teacherListQuery, $this->curPage, $this->pageSize);
		return $result;
	}
	
	public function filterSearch($search,ActiveQuery $query)
	{
		if(!isset($search) || empty($search)){
			return $query;
		}
		if(isset($search['trueName']) && !empty($search['trueName'])){
			$query= $query->andWhere(['like','trueName',$search['trueName']]);
		}
		if(isset($search['sex']) && !empty($search['sex'])){
			$query = $query->andWhere(['sex'=>$search['sex']]);
		}
		if(isset($search['from']) && !empty($search['from'])){
			$query = $query->andWhere(['like','from',$search['from']]);
		}

		if(!empty($search['startTime'])){
			$query = $query->andWhere('createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
		}
		if(!empty($search['endTime'])){
			$query = $query->andWhere('createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
		}
		return $query;
	}
	
	public function export(array $data)
	{
	    $query= self::find()->select([])->where(['isDelete'=>self::TEACHER_UNDELETE])->orderBy('createTime desc,modifyTime desc');
	    if($this->load($data)){
	        $query= $this->filterSearch($this->search, $query);
	    }
	    $result = $query->asArray()->all();
	    
	    $phpExcel = new \PHPExcel();
	    $objSheet = $phpExcel->getActiveSheet();
	    $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $objSheet->setTitle('教师列表');
	    $objSheet->setCellValue('A1','序号')->setCellValue('B1','教师姓名')->setCellValue('C1','手机号')->setCellValue('D1','性别')
	    ->setCellValue('E1','职称')->setCellValue('F1','行政职务')->setCellValue('G1','来源情况')->setCellValue('H1','授课专题')
	    ->setCellValue('I1','创建时间')->setCellValue('J1','修改时间');
	    $num  = 2;
	    foreach ($result as $val){
	        $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['trueName'])->setCellValue('C'.$num,$val['phone'])->setCellValue('D'.$num,$val['sex'] == 1 ? '男':'女')
	        ->setCellValue('E'.$num,$val['positionalTitles'])->setCellValue('F'.$num,$val['duties'])->setCellValue('G'.$num,$val['from'])->setCellValue('H'.$num,$val['teachTopics'])
	        ->setCellValue('I'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('J'.$num,MyHelper::timestampToDate($val['modifyTime']));
	        $num ++;
	    }
	    $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
	    ExcelMolde::exportBrowser('教师列表.xlsx');
	    $objWriter->save('php://output');
	}
	
	
	public function getTearchersByName(string $name = '')
	{
		$query = self::find()->select(['id','trueName'])->where(['isDelete'=>self::TEACHER_UNDELETE]);
		if(!empty($name)){
			$query = $query->andWhere(['like','trueName',$name]);
		}
		
		return $query->asArray()->all();
	}
}