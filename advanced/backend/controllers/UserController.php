<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\User;
use common\models\Role;

class UserController extends CommonController
{
    
    public function actionManage()
    {
        $model = new User();
        //$roles = Role::getRoles();
        $request = Yii::$app->request;
        $list = $model->users(['curPage'=>1], $request->post()); //$request->get()
        return $this->render('manage',['model'=>$model,'list'=>$list]);
    }
    
    
    
    public function actionReg()
    {
        $model = new User();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->reg($data);
            if($result){
                return $this->showSuccess('user/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        $model->userPwd= '';
        $model->repass  = '';
        $model->isFrozen  = 0;
        return $this->render('add',['model'=>$model,'title'=>'添加用户']);
    }
    
    public function actionEdit(int $id)
    {
        $user = User::findIdentity($id);
        if(empty($user)){
            return $this->showDataIsNull('user/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(User::edit($data, $user)){
                return $this->showSuccess('user/manage');
            }else{
                Yii::$app->session->setFlash('error',$user->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$user,'operat'=>'edit','title'=>'编辑用户']);
    }
    
    public function actionDel(int $id)
    {
        $user = User::findIdentity($id);
        if(empty($user)){
            return $this->showDataIsNull('user/manage');
        }
        if(User::del($user)){
            return $this->redirect(['user/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return User::updateAll(['isDelete'=>User::USER_DELETE],['in','id',$idsArr]);
    }
    
    
    public function actionResetpwd(int $id)
    {
        $user = User::findIdentity($id);
        if(empty($user)){
            return $this->showDataIsNull('user/manage');
        }
        if(User::resetPwd($user)){
            return $this->showSuccess('user/manage');
        }
    }
    
    public function actionFrozen(int $id)
    {
        $user = User::findIdentity($id);
        if(empty($user)){
            return $this->showDataIsNull('user/manage');
        }
        if(User::frozen($user)){
            return $this->showSuccess('user/manage');
        }
    }
    
    public function actionActive(int $id)
    {
        $user = User::findIdentity($id);
        if(empty($user)){
            return $this->showDataIsNull('user/manage');
        }
        if(User::active($user)){
            return $this->showSuccess('user/manage');
        }
    }
}