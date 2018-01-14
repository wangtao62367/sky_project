<?php
namespace backend\controllers;



use Yii;
use common\models\Admin;
use yii\web\Controller;
/**
 * @name 后台用户
 * @author wangt
 *
 */

class PublicController extends Controller
{
	
    /**
     * @desc 后台登陆
     * @return \yii\web\Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
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
    /**
     * @desc 登陆退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        if(Yii::$app->user->logout(false)){
            return $this->redirect(['public/login']);
        }
        return $this->goBack();
    }
    /**
     * @desc 忘记密码
     */
    public function actionForgetpwd()
    {
        
    }
    /**
     * @desc 邮件找回密码
     */
    public function actionFindpwdByMail()
    {
        
    }
    
    
    
}