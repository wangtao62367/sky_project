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
            $data = Yii::$app->request->post('data',[]);
            $result = $model->add(json_decode($data,true));
            if($result){
                return $this->showSuccess('image/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$model,'parentCates'=>$parentCates,'title'=>'添加视频']);
    }
}