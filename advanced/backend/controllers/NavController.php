<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\Common;
/**
 * @name 首页导航
 * @author wangt
 *
 */
class NavController extends CommonController
{
	
	/**
	 * @desc 导航列表
	 * @return string
	 */
	public function actionManage()
	{
		$navList = new Common();
		$list = $navList->getPageList();

		return $this->render('manage',['list'=>$list]);
	}
}