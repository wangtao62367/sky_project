<?php
namespace frontend\controllers;

use frontend\logic\SiteLogic;
use Yii;
use common\models\Article;
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
	    if(Yii::$app->request->isPost){
	        $search = Yii::$app->request->post();
	        if(empty($search)){
	            return $this->redirect(['site/index']);
	        }
	        $article = new Article();
	        $result = $article->articles($data,$search);
	        
	        $view = Yii::$app->view;
	        $view->params['searchModel'] = $article;
	        return $this->render('search',['result'=>$result]);
	        
	    }
	    return $this->redirect(['site/index']);
	}
}
