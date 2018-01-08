<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Common;
use common\models\BottomLink;
/**
 * 底部链接管理
 * @author wt
 *
 */
class BottomlinkController extends CommonController
{
	
	
	public function actionManage()
	{
		$model = new BottomLink();
		$cates = Common::getCommonListByType('bottomLink');
		$data = Yii::$app->request->get();
		$list = $model->getPageList($data);
		return $this->render('manage',['model'=>$model,'cates'=>$cates,'list'=>$list]);
	}
}