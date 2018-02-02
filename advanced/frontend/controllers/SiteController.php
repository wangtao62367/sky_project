<?php
namespace frontend\controllers;

use frontend\logic\SiteLogic;

/**
 * Site controller
 */
class SiteController extends CommonController
{
   
	public function actionIndex()
	{
	    $data = SiteLogic::index();
	    $this->cachePages = ['index'];
	    return $this->render('index');
	}
}
