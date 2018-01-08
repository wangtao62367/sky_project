<?php
namespace backend\controllers;

use Yii;
use common\controllers\CommonController;
use common\models\Photo;
use common\models\Category;
use yii\helpers\ArrayHelper;
use OSS\OssClient;

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
		$data = Yii::$app->request->get();
		$list = $model->getPageList($data);
		return $this->render('manage',['model'=>$model,'parentCates'=>$parentCates,'list'=>$list]);
	}
	
	public function actionAdd()
	{
	    $model = new Photo();
	    
	    $parentCates = Category::getArticleCates('image');
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = $model->add($data);
	        if($result){
	            return $this->showSuccess('image/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$model->getErrorDesc());
	        }
	    }
	    return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'添加图片']);
	}
	
	public function actionEdit(int $id)
	{
	    $photo = Photo::findOne($id);
	    if(empty($photo)){
	        return $this->showDataIsNull('image/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = Photo::edit($data,$photo);
	        if($result){
	            return $this->showSuccess('image/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$photo->getErrorDesc());
	        }
	    }
	    $parentCates = Category::getArticleCates('image');
	    return $this->render('add',['model'=>$photo,'parentCates'=>$parentCates,'title'=>'编辑图片']);
	}
	
	public function actionDel(int $id)
	{
	    $photo = Photo::findOne($id);
	    if(empty($photo)){
	        return $this->showDataIsNull('image/manage');
	    }
	    if(Photo::del($photo)){
	        return $this->redirect(['image/manage']);
	    }
	}
	
	
	
	
	public function actionUpload()
	{
	    $this->setResponseJson();
	    $files = $_FILES;
	    if(empty($files)){
	        return ['success'=>false];
	    }
	    $file = $files['file'];
	    
	    //验证类型
	    $ext = ['image/jpeg','image/png','image/jpg'];
	    if(!ArrayHelper::isIn($file['type'], $ext)){
	        return ['success'=>false,'message'=>'所选图片格式只能是jpg、png或jpeg'];
	    }
	    //验证大小
	    $maxSize = 500 * 1024;//500KB
	    if($file['size'] > $maxSize){
	        return ['success'=>false,'message'=>'所选图片大小不能超过500KB'];
	    }
	    
	    //随机字符串
	    $randNum = mt_rand(1, 1000000000) . mt_rand(1, 1000000000);
	    $bucket = Yii::$app->params['oss']['bucket'];
	    $block = '/upload/image/'.date('Y-m-d').'/'.$randNum.'.'.str_replace('image/', '', $file['type']);
	    $ossClient = new OssClient(Yii::$app->params['oss']['akey'], Yii::$app->params['oss']['skey'], Yii::$app->params['oss']['endpoint'], false);
	    //开始上传
	    $ossClient->uploadFile($bucket, ltrim($block,'/') , $file['tmp_name']);
	    //删除老图片
	    $oldFile = Yii::$app->request->post('oldFile','');
	    if(!empty($oldFile)){
	        $oldBlock = str_replace(Yii::$app->params['oss']['baseUrl'], '', $oldFile);
	        $ossClient->deleteObject($bucket, ltrim($oldBlock,'/'));
	    }
	    return ['success'=>true,'message'=>'上传成功','fileFullName'=>Yii::$app->params['oss']['baseUrl'].$block,'fileName'=>$block];
	}
	
}