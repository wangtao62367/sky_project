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
	
	public function actionAdd()
	{
	    $model = new BottomLink();
	    $cates = Common::getCommonListByType('bottomLink');
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = $model->add($data);
	        if($result){
	            return $this->showSuccess('bottomlink/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$model->getErrorDesc());
	        }
	    }
	    
	    return $this->render('add',['model'=>$model,'cates'=>$cates,'title'=>'添加底部链接']);
	}
	
	public function actionEdit(int $id)
	{
	    $model = BottomLink::findOne($id);
	    if(empty($model)){
	        return $this->showDataIsNull('bottomlink/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        if(BottomLink::edit($data, $model)){
	            return $this->showSuccess('bottomlink/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$model->getErrorDesc());
	        }
	    }
	    $cates = Common::getCommonListByType('bottomLink');
	    return $this->render('add',['model'=>$model,'cates'=>$cates,'title'=>'添加底部链接']);
	}
	
	public function actionDel(int $id)
	{
	    $model = BottomLink::findOne($id);
	    if(empty($model)){
	        return $this->showDataIsNull('bottomlink/manage');
	    }
	    if(BottomLink::del($model)){
	        return $this->redirect(['bottomlink/manage']);
	    }
	}
	
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return BottomLink::deleteAll(['in','id',$idsArr]);
	}
}