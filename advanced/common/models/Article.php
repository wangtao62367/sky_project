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
            ['title','required','message'=>'文章标题不能为空','on'=>'create'],
            ['author','required','message'=>'文章作者不能为空','on'=>'create'],
            ['summary','required','message'=>'文章摘要不能为空','on'=>'create'],
            ['content','required','message'=>'文章内容不能为空','on'=>'create'],
            ['categoryId','required','message'=>'文章分类不能为空','on'=>'create'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            
            if($this->save(false)){
                $this->batchAddArticleTags($this->tags,$this->id);
            };
            
        }
        return false;
    }
    
    public function batchAddArticleTags(array $tags,int $articleId)
    {
        
    }
}