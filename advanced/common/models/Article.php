<?php
namespace common\models;




class Article extends BaseModel
{
    public $tags;
    
    public static function tableName()
    {
        return '{{%Article}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'文章标题不能为空','on'=>['create','edit']],
            ['author','required','message'=>'文章作者不能为空','on'=>['create','edit']],
            ['summary','required','message'=>'文章摘要不能为空','on'=>['create','edit']],
            ['content','required','message'=>'文章内容不能为空','on'=>['create','edit']],
            ['categoryId','required','message'=>'文章分类不能为空','on'=>['create','edit']],
            [['isPublish','tags','search','imgCount'],'safe']
        ];
    }
    
    public function getArticletags()
    {
        return $this->hasMany(ArticleTag::className(), ['articleId'=>'id']);
    }
    
    public function getCategorys()
    {
        return $this->hasOne(Category::className(), ['id'=>'categoryId']);
    }
    
    
    public function articles(array $get,array $search)
    {
        $this->curPage = isset($get['curPage']) && !empty($get['curPage']) ? $get['curPage'] : $this->curPage;
        $query = self::find()
                ->with(['articletags'=>function(\yii\db\ActiveQuery $query){
                    $query->with(['tags']);
                }])
                ->with('categorys')
               ->where(['isDelete'=>0])
               ->orderBy('modifyTime desc');
        if (!empty($search) && $this->load($search)){
            if(!empty($this->search['keywords'])){
                $query = $query->andWhere(['or',['like','author',$this->search['keywords']],['like','title',$this->search['keywords']]]);
            }
            if(!empty($this->search['categoryId']) && $this->search['categoryId'] != 'unkown'){
                $query = $query->andWhere('categoryId = :categoryId',[':categoryId'=>$this->search['categoryId']]);
            }
            if(!empty($this->search['isPublish']) && $this->search['isPublish'] != 'unkown'){
                $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$this->search['isPublish']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            if($this->save(false)){
               return true;//self::batchAddArticleTags($this->tags,$this->id);
            };
            
        }
        return false;
    }
    
    public static function del(int $id,Article $article)
    {
        $article->isDelete = 1;
        return $article->save(false);
    }
    
    
}