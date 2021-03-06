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
use yii\db\Expression;
use common\models\FamousTeacher;
use common\models\ArticleRecommen;

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
                //统战故事
                'tzgs' => self::getTzgs(),
                //文学书画
                'wxsh' => self::getWxsh(),
                
            ];
            $cache->set($key, $newsdata,7200,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Article WHERE isPublish = 1 AND isDelete =0 ORDER BY modifyTime desc limit 1']));
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
            //名师堂
            'mmst' => self::getMmst(),
        ];
        
        return ArrayHelper::merge($newsdata, $ortherdata);
    }
    
    /**
     * 获取首页轮播
     */
    public static function getCarousel()
    {
        return [];
        $cache = Yii::$app->cache;
        $key = 'INDEX_Carousel';
        $result = $cache->get($key);
        if(!empty($result)){
            return $result;
        }
        $result = Carousel::find()->select(['id','title','link','img'])->orderBy('sorts asc,modifyTime desc')->all();
        $cache->set($key, $result,7200,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Carousel ORDER BY modifyTime desc limit 1']));
        return $result;
    }
    
    /**
     * 获取公告通知列表
     */
    public static function getGgtz()
    {
        $cate = Category::getCatesByCode('ggtz');
        $articles = Article::find()->select(['id','title','ishot','publishTime'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(8)->all();
        return $articles;
    }
    
    /**
     * 获取统战新闻
     */
    public static function getTzxw()
    {
        $cate = Category::getCatesByCode('tzxw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(1)->one();
        
        
        
        return $articles;
    }
    
    /**
     * 获取社院新闻列表
     */
    public static function getSyxw()
    {
        $cate = Category::getCatesByCode('syxw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取时政要闻列表
     */
    public static function getSzyw()
    {
        $cate = Category::getCatesByCode('szyw');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(5)->all();
        return $articles;
    }
    
    /**
     * 获取文化交流列表
     */
    public static function getWhjl()
    {
        $cate = Category::getCatesByCode('whjl');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取党群行政列表
     */
    public static function getDqxz()
    {
        $cate = Category::getCatesByCode('dqxz');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取教学培训列表
     */
    public static function getJxpx()
    {
        $cate = Category::getCatesByCode('jxxx');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    /**
     * 获取学员园地列表
     */
    public static function getXyyd()
    {
        $cate = Category::getCatesByCode('xyhd');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
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
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->Where(['in','categoryId',$catesIds])->andWhere(['isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    /**
     * 获取智库中心列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getZkzx()
    {
        $cate = Category::getCatesByCode('xxdt');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
        return $articles;
    }
    
    /**
     * 获取市州社院列表
     */
    public static function getSzsy()
    {
        $cate = Category::getCatesByCode('szsy');
        $articles = Article::find()->select(['id','title','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(7)->all();
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
        $videos = Video::find()->select(['id','videoImg','descr','video','videoType'])->where(['categoryId'=>$cate->id,'isDelete'=>0])->orderBy('sorts asc,modifyTime desc')->limit(10)->all();
        $cache->set($key, $videos,7200,new DbDependency(['sql'=>'SELECT count(1) FROM sky_Video WHERE isDelete = 0 AND categoryId='.$cate->id.' ORDER BY modifyTime desc limit 1']));
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
        $cache->set($key, $eduBases,7200,new DbDependency(['sql'=>'SELECT count(1) FROM sky_EducationBase ORDER BY modifyTime desc limit 1']));
        return $eduBases;
    }
    /**
     * 获取推荐文章列表
     * 
     */
    public static function getRecommen()
    {
        $list = ArticleRecommen::find()->joinWith('article')->where( ArticleRecommen::tableName().'.articleId != 0 ')->limit(3)->all();
       return $list;
    }
    /**
     * 名师堂
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMmst()
    {
       $list = FamousTeacher::find()->select('id,name,teach,avater')->orderBy('sorts ASC,id DESC')->limit(6)->all();
       return $list;
    }
    /**
     * 统战故事
     */
    public static function getTzgs()
    {
        $cate = Category::getCatesByCode('tzgs');
        $articles = Article::find()->select(['id','title','titleImg','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(2)->all();
        return $articles;
    }
    
    /**
     * 文学书画
     */
    public static function getWxsh()
    {
        $cate = Category::getCatesByCode('wxsh');
        $articles = Article::find()->select(['id','title','titleImg','publishTime','ishot','summary'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('publishTime desc')->limit(2)->all();
        return $articles;
    }
}