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
			[['curriculumId','curriculumText'],'required','message'=>'课程不能为空','on'=>['add','edit']],
		    [['teacherId','teacherName'],'required','message'=>'授课教师不能为空','on'=>['add','edit']],
		    [['teachPlaceId','teachPlace'],'required','message'=>'教学地点不能为空','on'=>['add','edit']],
		    [['gradeClassId','gradeClass'],'required','message'=>'教学班级不能为空','on'=>['add','edit']],
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
			
			if(!empty($this->search)){
				
			}
			
		}
		$result = $this->query($scheduleListQuery, $this->curPage, $this->pageSize);
		return $result;
	}
}