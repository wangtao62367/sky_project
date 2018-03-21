<?php
namespace frontend\logic;


use Yii;
use common\models\Category;
use common\models\Article;
use yii\helpers\ArrayHelper;
use common\models\Video;
use common\models\EducationBase;
use common\models\Carousel;
use yii\caching\DbDependency;

/**
 * 首页
 * @author wt
 *
 */
class SiteLogic
{
    
    public static function search($keywords)
    {
        
    }
    
    public static function index()
    {
        $cache = Yii::$app->cache;
        $key = 'INDEX_newsdata';
        $newsdata= $cache->get($key);
        if(empty($newsdata)){
            $newsdata =[
                //公告通知
                'ggtz' => self::getGgtz(),
                //统战新闻
                'tzxw' => self::getTzxw(),
                //社院新闻
                'syxw' => self::getSyxw(),
                //时政要闻
                'szyw' => self::getSzyw(),
                //文化学院
                'whjl' => self::getWhjl(),
                //党群行政
                'dqxz' => self::getDqxz(),
                //教学培训
                'jxpx' => self::getJxpx(),
                //学员园地
                'xyyd' => self::getXyyd(),
                //科研动态
                'kydt' => self::getKydt(),
                //智库中心
                'zkzx' => self::getZkzx(),
                //市州社院
                'szsy' => self::getSzsy(),
            ];
            $cache->set($key, $newsdata,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Article WHERE isPublish = 1 AND isDelete =0 ORDER BY modifyTime desc limit 1']));
        }
        $ortherdata = [
            //特色教育基地
            'jyjd' => self::getEducationBase(),
            //视讯社院
            'sxsy' => self::getSxsy(),
            //首页轮播
            'carousel' => self::getCarousel(),
            //首页推荐文章
            'recommen' => self::getRecommen(),
        ];
        
        return ArrayHelper::merge($newsdata, $ortherdata);
    }
    
    /**
     * 获取首页轮播
     */
    public static function getCarousel()
    {
        $cache = Yii::$app->cache;
        $key = 'INDEX_Carousel';
        $result = $cache->get($key);
        if(!empty($result)){
            return $result;
        }
        $result = Carousel::find()->select(['id','title','link','img'])->orderBy('sorts asc,modifyTime desc')->all();
        $cache->set($key, $result,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Carousel ORDER BY modifyTime desc limit 1']));
        return $result;
    }
    
    /**
     * 获取公告通知列表
     */
    public static function getGgtz()
    {
        $cate = Category::getCatesByCode('ggtz');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(5)->all();
        return $articles;
    }
    
    /**
     * 获取统战新闻
     */
    public static function getTzxw()
    {
        $cate = Category::getCatesByCode('tzxw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(1)->one();
        
        
        
        return $articles;
    }
    
    /**
     * 获取社院新闻列表
     */
    public static function getSyxw()
    {
        $cate = Category::getCatesByCode('syxw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取时政要闻列表
     */
    public static function getSzyw()
    {
        $cate = Category::getCatesByCode('szyw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取文化交流列表
     */
    public static function getWhjl()
    {
        $cate = Category::getCatesByCode('whjl');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取党群行政列表
     */
    public static function getDqxz()
    {
        $cate = Category::getCatesByCode('dqxz');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取教学培训列表
     */
    public static function getJxpx()
    {
        $cate = Category::getCatesByCode('jxxx');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    /**
     * 获取学员园地列表
     */
    public static function getXyyd()
    {
        $cate = Category::getCatesByCode('xyhd');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取科研动态列表
     */
    public static function getKydt()
    {
        //科研动态 下存在科研信息、科研成果为新闻文章
        $cates = Category::find()->select('id')->where(['in','cateCode',['kycg','jyxx']])->asArray()->all();
        $catesIds = ArrayHelper::getColumn($cates, 'id');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->Where(['in','categoryId',$catesIds])->andWhere(['isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    /**
     * 获取智库中心列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getZkzx()
    {
        $cate = Category::getCatesByCode('xxdt');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取市州社院列表
     */
    public static function getSzsy()
    {
        $cate = Category::getCatesByCode('szsy');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,sorts asc,publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取视讯社院列表
     */
    public static function getSxsy()
    {
        $cache = Yii::$app->cache;
        $key = 'INDEX_Sxsy';
        $result = $cache->get($key);
        if(!empty($result)){
            return $result;
        }
        $cate = Category::getCatesByCode('sxsy');
        $videos = Video::find()->select(['id','videoImg','descr','video'])->where(['categoryId'=>$cate->id,'isDelete'=>0])->orderBy('sorts asc,modifyTime desc')->limit(10)->all();
        $cache->set($key, $videos,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Video WHERE isDelete = 0 AND categoryId='.$cate->id.' ORDER BY modifyTime desc limit 1']));
        return $videos;
    }
    /**
     * 获取特色教育基地
     */
    public static function getEducationBase()
    {
        $cache = Yii::$app->cache;
        $key = 'INDEX_EducationBase';
        $result = $cache->get($key);
        if(!empty($result)){
            return $result;
        }
        $eduBases = EducationBase::find()->select(['id','baseName','baseImg','link'])->orderBy('sorts asc,modifyTime desc')->limit(10)->all();
        $cache->set($key, $eduBases,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_EducationBase ORDER BY modifyTime desc limit 1']));
        return $eduBases;
    }
    /**
     * 获取推荐文章列表
     * 
     */
    public static function getRecommen()
    {
        $cache = Yii::$app->cache;
        $key  = 'INDEX_Recommen';
        $list = $cache->get($key);
        if(!empty($list)){
            return $list;
        }
       $list = Article::find()->select(['id','title','titleImg','publishTime','ishot','summary'])->where(['isPublish'=>1,'isDelete'=>0])->andWhere(['<>','titleImg',''])->orderBy('isRecommen desc,ishot desc,sorts asc,publishTime desc,modifyTime desc')->limit(3)->all();
       $cache->set($key, $list,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Article WHERE isPublish = 1 AND isDelete =0 AND titleImg <> \'\' ORDER BY isRecommen desc,ishot desc,sorts asc,modifyTime desc limit 1']));
       return $list;
    }
}