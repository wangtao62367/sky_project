<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\User;
use common\models\Role;
/**
 * @name 用户管理
 * @author wangt
 *
 */
class UserController extends CommonController
{
    /**
     * @desc 用户列表
     * @return string
     */
    public function actionManage()
    {
        $model = new User();
        //$roles = Role::getRoles();
        $request = Yii::$app->request;
        $list = $model->users($request->get(), $request->get()); 
        return $this->render('manage',['model'=>$model,'list'=>$list]);
    }
    
    
    /**
     * @desc 添加用户
     * @return \yii\web\Response|string
     */
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
    /**
     * @desc 编辑用户
     * @param int $id
     * @return \yii\web\Response|string
     */
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
    /**
     * @desc 删除用户
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 批量删除用户
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return User::updateAll(['isDelete'=>User::USER_DELETE],['in','id',$idsArr]);
    }
    
    /**
     * @desc 重置用户密码
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 冻结用户
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 激活用户
     * @param int $id
     * @return \yii\web\Response
     */
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