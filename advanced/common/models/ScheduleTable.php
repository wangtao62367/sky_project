<?php
namespace common\models;






use yii\db\Query;

class ScheduleTable extends BaseModel
{
	
	
	public static function tableName()
	{
		return '{{%ScheduleTable}}';
	}
	
	
	public function rules()
	{
		return [
				[['curriculumId','curriculumText'],'required','message'=>'课程不能为空','on'=>['add','edit']],
			    [['teacherId','teacherName'],'required','message'=>'授课教师不能为空','on'=>['add','edit']],
			    [['teachPlaceId','teachPlace'],'required','message'=>'教学地点不能为空','on'=>['add','edit']],
			    [['lessonDate','lessonStartTime','lessonEndTime'],'required','message'=>'上课时间不能为空','on'=>['add','edit']],
				[['curPage','pageSize','search'],'safe'],
		];
	}
	
	public function add(array $data)
	{
		$this->scenario = 'add';
		if($this->load($data) && $this->validate() && $this->save(false)){
			return true;
		}
		return false;
	}
	
	public static function edit(array $data , ScheduleTable $model)
	{
		$model->scenario = 'edit';
		if($model->load($data) && $model->validate() && $model->save(false)){
			return true;
		}
		return false;
	}
	
	public static function del(ScheduleTable $model)
	{

		return $model->delete();
	}
	
	
	public function pageList($data,$field= '*')
	{
		$this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
		$query = self::find()->select($field)->orderBy('createTime desc,modifyTime desc');
		if($this->load($data) && !empty($this->search)){
			$query= $this->filterSearch($this->search, $query);
		}
		$result = $this->query($query, $this->curPage, $this->pageSize);
		return $result;
	}
	
	public function filterSearch(array $data,Query $query)
	{
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
		
		return $query;
	}
}