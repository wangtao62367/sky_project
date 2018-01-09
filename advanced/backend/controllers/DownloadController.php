<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Download;
use common\models\Category;

class DownloadController extends CommonController
{
	
	public function actionManage()
	{
		$model = new Download();
		
		$parentCates = Category::getArticleCates('file');
		$data = Yii::$app->request->get();
		$list = $model->getPageList($data);
		return $this->render('manage',['model'=>$model,'parentCates'=>$parentCates,'list'=>$list]);
	}
	
	public function actionAdd()
	{
		$model = new Download();
		
		$parentCates = Category::getArticleCates('file');
		if(Yii::$app->request->isPost){
			$data = Yii::$app->request->post();
			$result = $model->add($data);
			if($result){
				return $this->showSuccess('download/manage');
			}else{
				Yii::$app->session->setFlash('error',$model->getErrorDesc());
			}
		}
		return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'添加文件']);
	}
	
	public function actionEdit(int $id)
	{
		$model = Download::findOne($id);
		if(empty($model)){
			return $this->showDataIsNull('download/manage');
		}
		if(Yii::$app->request->isPost){
			$data = Yii::$app->request->post();
			if(Download::edit($data, $model)){
				return $this->showSuccess('download/manage');
			}else{
				Yii::$app->session->setFlash('error',$model->getErrorDesc());
			}
		}
		$parentCates = Category::getArticleCates('file');
		return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'编辑文件']);
	}
	
	public function actionDel(int $id)
	{
		$model = Download::findOne($id);
		if(empty($model)){
			return $this->showDataIsNull('download/manage');
		}
		if(Download::del($model)){
			return $this->redirect(['download/manage']);
		}
	}
	
	public function actionBatchdel()
	{
		$this->setResponseJson();
		$ids = Yii::$app->request->post('ids');
		$idsArr = explode(',',trim($ids,','));
		return Download::deleteAll(['in','id',$idsArr]);
	}
}