<?php
namespace backend\controllers;




use Yii;
use common\controllers\CommonController;
use common\models\Video;
use common\models\Category;
/**
 * 视频中心
 * @author wt
 *
 */
class VideoController extends CommonController
{
    
    
    public function actionManage()
    {
        $model = new Video();
        
        $parentCates = Category::getArticleCates('video');
        $data = \Yii::$app->request->get();
        $list = $model->getPageList($data);
        return $this->render('manage',['model'=>$model,'parentCates'=>$parentCates,'list'=>$list]);
    }
    
    public function actionAdd()
    {
        $model = new Video();
        
        $parentCates = Category::getArticleCates('video');
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->add($data);
            if($result){
                return $this->showSuccess('video/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'添加视频']);
    }
    
    public function actionEdit(int $id)
    {
    	$model = Video::findOne($id);
    	if(empty($model)){
    		return $this->showDataIsNull('video/manage');
    	}
    	if(Yii::$app->request->isPost){
    		$data = Yii::$app->request->post();
    		if(Video::edit($data, $model)){
    			return $this->showSuccess('video/manage');
    		}else{
    			Yii::$app->session->setFlash('error',$model->getErrorDesc());
    		}
    	}
    	$parentCates = Category::getArticleCates('video');
    	return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'编辑视频']);
    }
    
    public function actionDel(int $id)
    {
    	$model = Video::findOne($id);
    	if(empty($model)){
    		return $this->showDataIsNull('video/manage');
    	}
    	if(Video::del($model)){
    		return $this->redirect(['video/manage']);
    	}
    }
    
    public function actionBatchdel()
    {
    	$this->setResponseJson();
    	$ids = Yii::$app->request->post('ids');
    	$idsArr = explode(',',trim($ids,','));
    	return Video::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
}