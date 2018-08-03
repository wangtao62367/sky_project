<?php
namespace backend\controllers;


use Yii;
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
	/**
	 * @desc 编辑导航
	 * @param int $id
	 */
	public function actionEdit(int $id)
	{
	    $model = Common::findOne($id);
	    if(empty($model)){
	        return $this->showDataIsNull('/nav/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data= Yii::$app->request->post();
	        if(Common::edit($data,$model)){
	            return $this->showSuccess('/nav/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$model->getErrorDesc());
	        }
	    }
	    
	    return $this->render('edit',['model'=>$model]);
	}
}