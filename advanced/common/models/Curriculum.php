<?php
namespace common\models;



/**
 * 课程
 * @author wangtao
 *
 */

class Curriculum extends BaseModel
{
    
    const CURRICULUM_DELETE = 1;
    
    const CURRICULUM_UNDELETE = 0;
    
    public static function tableName()
    {
        return '{{%Curriculum}}';
    }
    
    
    public function rules()
    {
        return [
            ['text','required','message'=>'课程名称不能为空','on'=>['create','edit']],
            ['text', 'string' ,'length'=>[2,20],'tooLong'=>'课程名称长度为4-40个字符', 'tooShort'=>'课程名称长度为2-20个字','on'=>['create','edite']],
            [['period','isRequired','remarks','curPage','pageSize','search'],'safe']
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true ;
        }
        return false;
    }
    
    public function edit(array $data,int $id)
    {
        $curriculumInfo = self::findOne($id);
        if(empty($curriculumInfo)){
            $this->addError('id','数据不存在');
            return false;
        }
        $curriculumInfo->scenario = 'edit';
        if($curriculumInfo->load($data) && $curriculumInfo->validate() && $curriculumInfo->save(false)){
            return true;
        }
        return  false;
    }
    
    public function del(int $id)
    {
        $curriculumInfo = self::findOne($id);
        if(empty($curriculumInfo)){
            $this->addError('id','数据不存在');
            return false;
        }
        $curriculumInfo->isDelete = self::CURRICULUM_DELETE;
        return $curriculumInfo->save(false);
    }
    
    public function pageList(array $data)
    {
        if($this->load($data)){
            $curriculumListQuery = self::find()->select([])->where(['isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
            if(!empty($this->search)){
               if(!empty($this->search['text'])){
                   $curriculumListQuery = $curriculumListQuery->andWhere(['like','text',$this->search['text']]);
               } 
               if(!empty($this->search['isRequired'])){
                   $curriculumListQuery = $curriculumListQuery->andWhere('isRequired = :isRequired',[':isRequired'=>$this->search['isRequired']]);
               }
            }
            $result = $this->query($curriculumListQuery, $this->curPage, $this->pageSize);
            return $result;
        }
        return false;
    }
}