<?php
namespace backend\controllers;


use common\controllers\CommonController;
use common\models\Photo;
use common\models\Category;

/**
 * 内容管理-》图片模块
 * @author wt
 *
 */
class ImageController extends CommonController
{
	
	
	public function actionManage()
	{
		$model = new Photo();
		
		$parentCates = Category::getArticleCates('image');
		
		return $this->render('manage',['model'=>$model,'parentCates'=>$parentCates]);
	}
	
}