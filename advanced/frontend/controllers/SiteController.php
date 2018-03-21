<?php
namespace frontend\controllers;

use frontend\logic\SiteLogic;
use Yii;
use common\models\Article;
use common\models\Adv;
use common\publics\MyHelper;
use yii\caching\ExpressionDependency;
/**
 * Site controller
 */
class SiteController extends CommonController
{
   
	public function actionIndex()
	{
	    $this->layout = 'index';
	    $data = SiteLogic::index();
	    $this->cachePages = ['index'];
	    return $this->render('index',['data'=>$data]);
	}
	
	public function actionSearch()
	{
	    $this->layout = 'index';
	    $data = Yii::$app->request->get();
	    if(empty($data)){
            return $this->redirect(['site/index']);
        }
        $data['Article']['search']['isPublish'] = 1;
        $article = new Article();
        $result = $article->articles($data,$data);
        
        $view = Yii::$app->view;
        $view->params['searchModel'] = $article;
        return $this->render('search',['result'=>$result,'keywords'=>$data['Article']['search']['keywords']]);
	}
	
	public function actionClosing()
	{
		$this->layout = 'index';
		return $this->render('closing');
	}
	
	public function actionError()
	{
		$this->layout = false;
		return $this->render('error');
	}
	
	
	public function actionAdv()
	{
	    $this->setResponseJson();
	    $adv = Adv::find()->all();
	    return $adv;
	}
	
	public function actionGetweather()
	{
	    $cache = Yii::$app->cache;
	    $key = 'INDEX_weatherinfo';
	    $res = $cache->get($key);
	    if(!empty($res)){
	        return $res;
	    }
	    //成都地区的天气
	    $url = 'http://www.weather.com.cn/data/cityinfo/101270101.html';
	    $this->setResponseJson();
	    $res = MyHelper::httpGet($url);
	    $cache->set($key, $res,null,new ExpressionDependency(['expression'=>strtotime(date('Y-m-d'))]));
	    return $res;
	}
}
