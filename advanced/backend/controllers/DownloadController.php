<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Download;
use common\models\Category;
/**
 * @name 下载中心
 * @author wangt
 *
 */
class DownloadController extends CommonController
{
	/**
	 * @desc 下载列表
	 * @return string
	 */
	public function actionManage()
	{
		$model = new Download();
		$data = Yii::$app->request->get();
		$export = Yii::$app->request->get('handle','');
		if(strtolower(trim($export)) == 'export'){
		    $model->export($data);
		    Yii::$app->end();exit();
		}
		
		$parentCates = Category::getArticleCates('file');
		
		$list = $model->getPageList($data);
		return $this->render('manage',['model'=>$model,'parentCates'=>$parentCates,'list'=>$list]);
	}
	/**
	 * @desc 添加下载文件
	 * @return \yii\web\Response|string
	 */
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
	/**
	 * @desc 编辑下载文件
	 * @param int $id
	 * @return \yii\web\Response|string
	 */
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
	/**
	 * @desc 删除下载文件
	 * @param int $id
	 * @return \yii\web\Response
	 */
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
	/**
	 * @desc 批量删除文件
	 * @return number
	 */
	public function actionBatchdel()
	{
		$this->setResponseJson();
		$ids = Yii::$app->request->post('ids');
		$idsArr = explode(',',trim($ids,','));
		return Download::deleteAll(['in','id',$idsArr]);
	}

}