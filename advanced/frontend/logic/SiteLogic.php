<?php
namespace frontend\logic;


use common\models\Category;
use common\models\Article;
use yii\helpers\ArrayHelper;
use common\models\Video;
use common\models\EducationBase;
use common\models\Carousel;

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
        $data =[
            //公告通知
            'ggtz' => self::getGgtz(),
            //统战新闻
            'tzxw' => self::getTzxw(),
            //社院新闻
            'syxw' => self::getSyxw(),
            //时政要闻
            'szyw' => self::getSzyw(),
            //文化交流
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
            //特色教育基地
            'jyjd' => self::getEducationBase(),
            //视讯社院
            'sxsy' => self::getSxsy(),
            //首页轮播
            'carousel' => self::getCarousel()
        ];
        return $data;
    }
    
    /**
     * 获取首页轮播
     */
    public static function getCarousel()
    {
        $result = Carousel::find()->select(['id','title','link','img'])->orderBy('sorts desc')->all();
        //$result = Article::find()->select(['id','title','titleImg','ishot'])->where(['isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(5)->all();
        return $result;
    }
    
    /**
     * 获取公告通知列表
     */
    public static function getGgtz()
    {
        $cate = Category::getCatesByCode('ggtz');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(8)->all();
        return $articles;
    }
    
    /**
     * 获取统战新闻列表
     */
    public static function getTzxw()
    {
        $cate = Category::getCatesByCode('tzxw');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取社院新闻列表
     */
    public static function getSyxw()
    {
        $cate = Category::getCatesByCode('syxw');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取时政要闻列表
     */
    public static function getSzyw()
    {
        $cate = Category::getCatesByCode('szyw');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取文化交流列表
     */
    public static function getWhjl()
    {
        $cate = Category::getCatesByCode('whjl');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取党群行政列表
     */
    public static function getDqxz()
    {
        $cate = Category::getCatesByCode('dqxz');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取教学培训列表
     */
    public static function getJxpx()
    {
        $cate = Category::getCatesByCode('jxxx');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    /**
     * 获取学员园地列表
     */
    public static function getXyyd()
    {
        $cate = Category::getCatesByCode('xyhd');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
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
        $articles = Article::find()->select(['id','title','ishot'])->Where(['in','categoryId',$catesIds])->andWhere(['isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    /**
     * 获取智库中心列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getZkzx()
    {
        $cate = Category::getCatesByCode('xxdt');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取市州社院列表
     */
    public static function getSzsy()
    {
        $cate = Category::getCatesByCode('szsy');
        $articles = Article::find()->select(['id','title','ishot'])->where(['categoryId'=>$cate->id,'isPublish'=>1,'isDelete'=>0])->orderBy('ishot desc,publishTime desc')->limit(6)->all();
        return $articles;
    }
    
    /**
     * 获取视讯社院列表
     */
    public static function getSxsy()
    {
        $cate = Category::getCatesByCode('sxsy');
        $videos = Video::find()->select(['id','videoImg','descr','video'])->where(['categoryId'=>$cate->id,'isDelete'=>0])->orderBy('modifyTime desc')->limit(10)->all();
        return $videos;
    }
    /**
     * 获取特色教育基地
     */
    public static function getEducationBase()
    {
        $eduBases = EducationBase::find()->select(['id','baseName','baseImg','link'])->orderBy('modifyTime desc')->limit(10)->all();
        return $eduBases;
    }
}