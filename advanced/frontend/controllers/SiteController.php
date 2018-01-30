<?php
namespace frontend\controllers;

/**
 * Site controller
 */
class SiteController extends CommonController
{
   
	public function actionIndex()
	{
		return $this->render('index');
	}
}
