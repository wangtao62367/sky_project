<?php
namespace common\models;





class EducationBase extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%EducationBase}}';
    }
    
    public function rules()
    {
        return [
            ['baseName','required','message'=>'基地名称不能为空','on'=>['create','edit']],
            ['baseName', 'string', 'length' => [2, 10], 'tooLong'=>'基地名称长度为4-20个字符', 'tooShort'=>'基地名称长度为2-10个字','on'=>['create','edite']],
            ['baseImg','required','message'=>'基地名称图片不能为空','on'=>['create','edit']],
            ['link','required','message'=>'基地名称链接不能为空','on'=>['create','edit']],
            ['sorts','default','value'=>100000],
            [['sorts','search'],'safe']
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
    
    public static function edit(array $data , EducationBase $educationBase)
    {
        $educationBase->scenario = 'edit';
        if($educationBase->load($data) && $educationBase->validate() && $educationBase->save(false)){
            return true;
        }
        return false;
    }
    
    public static function del(EducationBase $educationBase)
    {
        return $educationBase->delete();
    }
    
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $this->pageSize = 5;
        $teachPlaceQuery = self::find()->select(['id','baseName','baseImg','link','sorts','createTime','modifyTime'])->orderBy('sorts asc,createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search) ){
            if(!empty($this->search['keywords'])){
                $teachPlaceQuery = $teachPlaceQuery->andWhere(['like','baseName',$this->search['keywords']]);
            }
        }
        $list = $this->query($teachPlaceQuery, $this->curPage, $this->pageSize);
        return $list;
    }
    
    
}