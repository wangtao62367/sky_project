<?php
namespace common\models;


use Yii;

/**
 * 班级
 * @author wangtao
 *
 */

class GradeClass extends BaseModel
{
    const GRADECLASS_DELETE = 1;
    const GRADECLASS_UNDELETE = 0;
    
    public static function tableName()
    {
        return '{{%GradeClass}}';    
    }
    
    public function rules()
    {
        return [
            ['className','required','message'=>'班级名称不能为空','on'=>['create','edite']],
            ['className', 'string','length'=>[2,20], 'tooLong'=>'班级名称长度为4-40个字符', 'tooShort'=>'班级名称长度为2-20个字','on'=>['create','edite']],
            ['classSize','required','message'=>'班级人数不能为空','on'=>['create','edite']],
            ['classSize','number','max'=>60,'min'=>5,'tooBig'=>'班级最小5人','tooSmall'=>'班级最大60人','on'=>['create','edite']],
            ['createAdminId','default','value'=>Yii::$app->user->id],
            [['curPage','pageSize','search'],'safe']
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
    
    public function edit(array $data,int $id)
    {
        $gradeClassInfo = self::findOne($id);
        if(empty($gradeClassInfo)){
            $this->addError('id','当前班级不存在');
            return false;
        }
        $this->scenario = 'edit';
        if($gradeClassInfo->load($data) && $this->validate() && $gradeClassInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public function del(int $id)
    {
        $gradeClassInfo = self::findOne($id);
        if(empty($gradeClassInfo)){
            $this->addError('id','当前班级不存在');
            return false;
        }
        $gradeClassInfo->isDelete = self::GRADECLASS_DELETE;
        return $gradeClassInfo->save(false);
    }
    
    public function pageList(array $data)
    {
        if($this->load($data)){
            $gradeClassQuery = self::find()->select([])->orderBy('createTime desc,modifyTime desc');
            if(!empty($this->search)){
                if(!empty($this->search['className'])){
                    $gradeClassQuery = $gradeClassQuery->andWhere(['like','className',$this->search['className']]);
                }
            }
            $list = $this->query($gradeClassQuery, $this->curPage, $this->pageSize);
            return $list;
        }
        return false;
    }
    
}