<?php
namespace frontend\logic;



use common\models\Article;
use common\models\Category;
use common\models\CategoryType;
use common\models\Common;

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
        $category = Category::find()->select([Category::tableName().'.id','text','parentId','codeDesc',Common::tableName().'.code'])->joinWith('parents')->where([Category::tableName().'.id'=>$article->categoryId,Category::tableName().'.isDelete'=>0])->asArray()->one();
        return $category;
    }
    /**
    * 获取文化交流文章列表
    * @date: 2018年2月8日 下午5:21:05
    * @author: wangtao
    */
    public static function getWhjlList($limit = 5)
    {
        $cateId = Category::find()->select('id')->where(['cateCode'=>CategoryType::WHJL])->one()->id;
        return Article::find()->select([
            'id',
            'title',
            'summary'
        ])->where(['isDelete'=>0,'isPublish'=>1,'categoryId'=>$cateId])
        ->orderBy('ishot desc,publishTime desc')->limit($limit)->asArray()->all();
    }
    /**
     * 获取文化论坛文章列表
     * @date: 2018年2月8日 下午5:21:05
     * @author: wangtao
     */
    public static function getWhltList($limit = 5)
    {
        $cateId = Category::find()->select('id')->where(['cateCode'=>CategoryType::WHLT])->one()->id;
        return Article::find()->select([
            'id',
            'title',
            'summary'
        ])->where(['isDelete'=>0,'isPublish'=>1,'categoryId'=>$cateId])
        ->orderBy('ishot desc,publishTime desc')->limit($limit)->asArray()->all();
    }
}