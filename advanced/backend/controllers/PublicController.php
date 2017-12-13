<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Admin;

class PublicController extends CommonController
{
    
    
    public function actionLogin()
    {
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->login($post);
            if($result){
                
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    
    public function actionLogout()
    {
        
    }
    
    public function actionFindpwdByMail()
    {
        
    }
    
    
    
}