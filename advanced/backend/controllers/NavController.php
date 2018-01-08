<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\Common;

class NavController extends CommonController
{
	
	
	public function actionManage()
	{
		$navList = new Common();
		$list = $navList->getPageList();
		return $this->render('manage',['list'=>$list]);
	}
}