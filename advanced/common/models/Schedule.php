<?php
namespace common\models;


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
		return '{{%schedule}}';
	}
	
	public function rules()
	{
		return [
				
		];
	}
	
	public function getTeachplace()
	{
		return $this->hasOne(TeachPlace::className(), ['id'=>'teachPlaceId']);
	}
	
	public function getGradeclass()
	{
		return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
	}
	
	public function pageList(array $data)
	{
		if($this->load($data)){
			$scheduleListQuery = self::find()
				->select([])
				->joinWith('teachplace')
				->joinWith('gradeclass')
				->where([self::tableName().'.isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
			if(!empty($this->search)){
				
			}
			$result = $this->query($scheduleListQuery, $this->curPage, $this->pageSize);
			return $result;
		}
		return false;
	}
}