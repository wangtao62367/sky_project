<?php
namespace common\models;


/**
 * 教师
 * @author wangtao
 *
 */
class Teacher extends BaseModel
{
	const CURRICULUM_DELETE = 1;
	
	const CURRICULUM_UNDELETE = 0;
	
	public static function tableName()
	{
		return '{{%teacher}}';
	}
	
	public function rules()
	{
		return [
				
		];
	}
	
	public function pageList(array $data)
	{
		if($this->load($data)){
			$teacherListQuery = self::find()->select([])->where(['isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
			if(!empty($this->search)){
				if(!empty($this->search['trueName'])){
					$teacherListQuery = $teacherListQuery->andWhere(['like','trueName',$this->search['trueName']]);
				}
				if(!empty($this->search['sex'])){
					$teacherListQuery = $teacherListQuery->andWhere('sex = :sex',[':sex'=>$this->search['sex']]);
				}
			}
			$result = $this->query($teacherListQuery, $this->curPage, $this->pageSize);
			return $result;
		}
		return false;
	}
}