<?php
namespace common\models;





class Video extends BaseModel
{
    public $oldVideoImg;
    
    public static function tableName()
    {
        return '{{%Video}}';
    }
    
    public function rules()
    {
        return [
            ['video','required','message'=>'视频不能为空','on'=>['add','edit']],
            ['categoryId','required','message'=>'视频分类不能为空','on'=>['add','edit']],
            ['descr','required','message'=>'视频名称不能为空','on'=>['add','edit']],
            [['search','oldVideoImg'],'safe']
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
    
    public static function edit(array $data,Video $video)
    {
        $video->scenario = 'edit';
        if($video->load($data) && $video->validate()){
            return $video->save(false);
        }
        return true;
    }
    
    public static function del(Video $video)
    {
        $video->isDelete = 1;
        return $video->save(false);
    }
    
    
    public function getPageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select([])->where(['isDelete'=>0])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
            if(!empty($this->search)){
                if(!empty($this->search['descr'])){
                    $query= $query->andWhere(['like','descr',$this->search['descr']]);
                }
                if(!empty($this->search['categoryId'])){
                    $query= $query->andWhere('categoryId = :categoryId',[':categoryId'=>$this->search['categoryId']]);
                }
            }
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
}