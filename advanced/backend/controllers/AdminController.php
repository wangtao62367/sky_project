<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Admin;

class AdminController extends CommonController
{
    
    public function actionManage()
    {
        $admin = new Admin();
        $data = Yii::$app->request->get();
        $list = $admin->admins($data);
        return $this->render('manage',['model'=>$admin,'list'=>$list]);
    }
    
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
    			return $this->showSuccess('default/main');
    		}else {
    			Yii::$app->session->setFlash('error',$admin->getErrorDesc());
    		}
    	}
    	$admin->adminPwd= '';
    	$admin->repass   = '';
    	return $this->render('add',['model'=>$admin,'title'=>'编辑管理员','operat'=>'edit']);
    }
    
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
    
    public function actionBatchdel()
    {
    	$this->setResponseJson();
    	$ids = Yii::$app->request->post('ids');
    	$idsArr = explode(',',trim($ids,','));
    	return Admin::deleteAll(['in','id',$idsArr]);
    }
    
    
    public function actionAuth()
    {
        
        return $this->render('auth');
    }
    
    public function actionAjaxResetpwd(int $id)
    {
        $this->setResponseJson();
        $admin = Admin::findIdentity($id);
        if(empty($admin)){
            return false;
        }
        $admin->adminPwd = Yii::$app->getSecurity()->generatePasswordHash('111111');
        return (bool)$admin->save(false);
    }
    
    public function actionAjaxDel(int $id){
        $this->setResponseJson();
        return (bool)Admin::deleteAll('id = :id',[':id'=>$id]);
    }
}