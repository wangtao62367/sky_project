<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Admin;

class PublicController extends CommonController
{
    
    
    public function actionLogin()
    {
        $this->layout = 'public';
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->login($post);
            if($result){
                return $this->redirect(['default/index']);
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    
    public function actionLogout()
    {
        if(Yii::$app->user->logout(false)){
            return $this->redirect(['public/login']);
        }
        return $this->goBack();
    }
    
    public function actionFindpwdByMail()
    {
        
    }
    
    
    
}