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
	    var_dump($data);
		//return $this->render('index');
	}
}
