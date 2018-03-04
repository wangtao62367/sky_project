<?php
namespace frontend\controllers;

use frontend\logic\SiteLogic;
use Yii;
use common\models\Article;
use common\models\Adv;
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
}
