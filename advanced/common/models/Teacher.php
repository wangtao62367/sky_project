<?php
namespace common\models;


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
		return '{{%teacher}}';
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
		    [['sex','createAdminId','curPage','pageSize','search'],'safe'],
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
		if($this->load($data)){
		    $teacherListQuery = self::find()->select([])->where(['isDelete'=>self::TEACHER_UNDELETE])->orderBy('createTime desc,modifyTime desc');
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