<?php
namespace backend\controllers;



use common\controllers\CommonController;

class CarouselController extends CommonController
{
	
	public function actionManage()
	{
		
		return $this->render('manage');
	}
	
	
	public function actionAdd()
	{
		
		
		return $this->render('add');
	}
}