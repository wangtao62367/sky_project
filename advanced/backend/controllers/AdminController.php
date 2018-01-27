<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Admin;
use backend\models\Rbac;
/**
 * @name 管理员管理
 * @author wangt
 *
 */
class AdminController extends CommonController
{
    /**
     * @desc 管理员列表
     * @return string
     */
    public function actionManage()
    {
        $admin = new Admin();
        $data = Yii::$app->request->get();
        $list = $admin->admins($data);
        return $this->render('manage',['model'=>$admin,'list'=>$list]);
    }
    /**
     * @desc 添加管理员
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $admin = new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $admin->add($post);
            if($result){
            	return $this->showSuccess('admin/manage');
            }else {
                Yii::$app->session->setFlash('error',$admin->getErrorDesc());
            }
        }
        $admin->adminPwd= '';
        $admin->repass   = '';
        return $this->render('add',['model'=>$admin,'title'=>'添加管理员']);
    }
    /**
     * @desc 编辑管理员
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('default/main');
    	}
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		$result = Admin::edit($post,$admin);
    		if($result){
    			return $this->showSuccess('admin/main');
    		}else {
    			Yii::$app->session->setFlash('error',$admin->getErrorDesc());
    		}
    	}
    	$admin->adminPwd= '';
    	$admin->repass   = '';
    	return $this->render('add',['model'=>$admin,'title'=>'编辑管理员','operat'=>'edit']);
    }
    /**
     * @desc 修改管理员密码
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEditpwd(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('default/main');
    	}
    	if(Yii::$app->request->isPost){
    		$post = Yii::$app->request->post();
    		$result = Admin::editPwd($post,$admin);
    		if($result){
    			return $this->showSuccess('default/main');
    		}else {
    			Yii::$app->session->setFlash('error',$admin->getErrorDesc());
    		}
    	}
    	$admin->adminPwd= '';
    	$admin->repass   = '';
    	$admin->oldPwd = '';
    	return $this->render('editpwd',['model'=>$admin,'title'=>'修改密码']);
    }
    /**
     * @desc 重置管理员密码
     * @param int $id
     * @return unknown
     */
    public function actionResetpwd(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	if(Admin::resetPwd($admin)){
    		return $this->showSuccess('admin/manage');
    	}
    }
    /**
     * @desc 冻结管理员
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionFrozen(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	if(Admin::frozen($admin)){
    		return $this->showSuccess('admin/manage');
    	}
    }
    /**
     * @desc 激活管理员
     * @param int $id
     * @return unknown
     */
    public function actionActive(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	if(Admin::active($admin)){
    		return $this->showSuccess('admin/manage');
    	}
    }
    /**
     * @desc 删除管理员
     * @param int $id
     * @return unknown
     */
    public function actionDel(int $id)
    {
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	if(Admin::del($admin)){
    		return $this->redirect(['admin/manage']);
    	}
    }
    /**
     * @desc 批量删除管理员
     * @return number
     */
    public function actionBatchdel()
    {
    	$this->setResponseJson();
    	$ids = Yii::$app->request->post('ids');
    	$idsArr = explode(',',trim($ids,','));
    	return Admin::deleteAll(['in','id',$idsArr]);
    }
    /**
     * @desc 管理员授权
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionAssign(int $id)
    {
    	if(empty($id)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	$admin = Admin::findIdentity($id);
    	if(empty($admin)){
    		return $this->showDataIsNull('admin/manage');
    	}
    	if(Yii::$app->request->isPost){
    		$children= Yii::$app->request->post('children',[]);
    		if(Rbac::grant($id,$children)){
    			return $this->showSuccess('admin/manage');
    		}
    	}
    	$auth = Yii::$app->authManager;
    	$rolse = Rbac::getOptions($auth->getRoles(), null);
    	$permissions = Rbac::getOptions($auth->getPermissions(), null);
    	
    	$children = Rbac::getChildrenByUser($id);
    	return $this->render('assign',['roles'=>$rolse,'permissions'=>$permissions,'children'=>$children,'admin'=>$admin,'title'=>'管理员授权']);
    }
    
}