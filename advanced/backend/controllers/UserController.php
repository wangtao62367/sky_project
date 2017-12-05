<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\User;
use common\models\Role;

class UserController extends CommonController
{
    
    public function actionUsers()
    {
        $model = new User();
        $roles = Role::getRoles();
        $request = Yii::$app->request;
        $list = $model->users($request->get(), $request->post());
        return $this->render('users',['model'=>$model,'roles'=>$roles,'list'=>$list]);
    }
    
    
    
    public function actionReg()
    {
        $model = new User();
        $roles = Role::getRoles();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->reg($data);
            if($result){
                Yii::$app->session->setFlash('success','添加成功');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        $model->userPwd= '';
        $model->repass  = '';
        return $this->render('reg',['model'=>$model,'roles'=>$roles]);
    }
    
    public function actionAjaxResetpwd(int $id)
    {
        $this->setResponseJson();
        return User::ajaxResetpwd($id);
    }
    
    public function actionAjaxDel(int $id)
    {
        $this->setResponseJson();
        return User::ajaxDel($id);
    }
}