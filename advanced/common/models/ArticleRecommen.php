<?php
namespace common\models;





class ArticleRecommen extends BaseModel
{
    
    
    public static function tableName()
    {
        return '{{%ArticleRecommen}}';
    }
    
    
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id'=>'articleId']);
    }
    
}