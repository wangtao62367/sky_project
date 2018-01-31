<?php
namespace frontend\logic;



use common\models\Article;
use common\models\Category;

class NewsLogic
{
    
    
    public static function getDetail(int $id)
    {
        $article = Article::find()->select([
            'id',
            'title',
            'author',
            'summary',
            'content',
            'contentCount',
            'source',
            'sourceLinke',
            'readCount',
            'categoryId',
            'publishTime'
        ])->where(['id'=>$id,'isDelete'=>0,'isPublish'=>1])->one();
        if(empty($article)){
            return false;
        }
        return $article;
    }
    
    public static function getPreByCurrent($article)
    {
        $pre = Article::find()->select([
            'id',
            'title',
        ])->where(['isDelete'=>0,'isPublish'=>1,'categoryId'=>$article->categoryId])->andWhere('publishTime < :publishTime',[':publishTime'=>$article->publishTime])
        ->orderBy('ishot desc,publishTime desc')->limit(1)->one();
        return $pre;
    }
    
    public static function getNextByCurrent($article)
    {
        $next = Article::find()->select([
            'id',
            'title',
        ])->where(['isDelete'=>0,'isPublish'=>1,'categoryId'=>$article->categoryId])->andWhere('publishTime > :publishTime',[':publishTime'=>$article->publishTime])
        ->orderBy('ishot desc,publishTime desc')->limit(1)->one();
        return $next;
    }
    
    /**
     * 获取文章详情页 面包屑导航
     */
    public static function getCrumbs($article)
    {
        $category = Category::find()->select([Category::tableName().'.id','text','parentId'])->joinWith('parents')->where([Category::tableName().'.id'=>$article->categoryId,'isDelete'=>0])->one();
        return $category;
    }
}