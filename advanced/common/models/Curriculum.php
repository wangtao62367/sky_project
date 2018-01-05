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
            ['period','required','message'=>'课时数不能为空','on'=>['create','edit']],
            ['period','integer','message'=>'课时数必须是整数数字','on'=>['create','edit']],
            [['isRequired','remarks','curPage','pageSize','search'],'safe']
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
    
    public static function edit(array $data,Curriculum $curriculumInfo)
    {
        $curriculumInfo->scenario = 'edit';
        if($curriculumInfo->load($data) && $curriculumInfo->validate() && $curriculumInfo->save(false)){
            return true;
        }
        return  false;
    }
    
    public static function del(int $id,Curriculum $curriculumInfo)
    {
        $curriculumInfo->isDelete = self::CURRICULUM_DELETE;
        return $curriculumInfo->save(false);
    }
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $curriculumListQuery = self::find()->select([])->where(['isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
            
            if(!empty($this->search)){
               if(!empty($this->search['text'])){
                   $curriculumListQuery = $curriculumListQuery->andWhere(['like','text',$this->search['text']]);
               } 
               if(!empty($this->search['isRequired'])){
                   $curriculumListQuery = $curriculumListQuery->andWhere('isRequired = :isRequired',[':isRequired'=>$this->search['isRequired']]);
               }
            }
            
        }
        $result = $this->query($curriculumListQuery, $this->curPage, $this->pageSize);
        return $result;
    }
}