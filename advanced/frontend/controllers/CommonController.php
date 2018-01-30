<?php
namespace frontend\controllers;



use Yii;
use yii\web\Controller;
use common\models\WebCfg;
use common\models\Common;

class CommonController extends Controller
{
	
	public function init()
	{
		$webCfgs = WebCfg::getWebCfg();
		$nav     = $this->getNav();
		$view = Yii::$app->view;
		$view->params['webCfgs'] = $webCfgs;
		$view->params['nav'] = $nav;
	}
	
	public function getNav()
	{
		$commonMolde = new Common();
		return $commonMolde->getNav();
	}
}

