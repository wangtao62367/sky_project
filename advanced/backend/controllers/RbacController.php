<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use yii\db\Query;
use backend\models\Rbac;
/**
 * @name 权限管理
 * @author wt
 *
 */
class RbacController extends CommonController
{
	/**
	 * @desc 创建角色
	 * @return \yii\web\Response|string
	 */
	public function actionCreaterole()
	{
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if(empty($post['description'])){
				Yii::$app->session->setFlash('error','角色名称不能为空');
			}elseif(empty($post['name'])){
				Yii::$app->session->setFlash('error','角色标识不能为空');
			}else{
				$authManage = Yii::$app->authManager;
				$role = $authManage->createRole(null);
				$role->description = $post['description'];
				$role->name = $post['name'];
				$role->ruleName = empty($post['rule_name']) ? null : $post['rule_name'];
				$role->data = empty($post['data']) ? null : $post['data'];
				if($authManage->add($role)){
					return $this->showSuccess('rbac/roles');
				}
			}
		}
		return $this->render('createitem',['title'=>'创建角色','role'=>null]);
	}
	/**
	 * @desc 角色列表
	 * @return string
	 */
	public function actionRoles()
	{
		$authManage = Yii::$app->authManager;
		$roles = $authManage->getRoles();
		return $this->render('roles',['roles'=>$roles]);
	}
	/**
	 * @desc 编辑角色
	 * @param string $name
	 * @return \yii\web\Response|string
	 */
	public function actionEditrole(string $name)
	{
		$authManage = Yii::$app->authManager;
		$role = $authManage->getRole($name);
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if(empty($post['description'])){
				Yii::$app->session->setFlash('error','角色名称不能为空');
			}elseif(empty($post['name'])){
				Yii::$app->session->setFlash('error','角色标识不能为空');
			}else{
				
				$role->description = $post['description'];
				$role->name = $post['name'];
				$role->ruleName = empty($post['rule_name']) ? null : $post['rule_name'];
				$role->data = empty($post['data']) ? null : $post['data'];
				if($authManage->update($name, $role)){
					return $this->showSuccess('rbac/roles');
				}
			}

		}
		return $this->render('createitem',['title'=>'编辑角色','role'=>$role]);
	}
	/**
	 * @desc 删除角色
	 * @param string $name
	 * @return \yii\web\Response
	 */
	public function actionDelrole(string $name)
	{
		$name = htmlspecialchars($name);
		$authManage = Yii::$app->authManager;
		$role = $authManage->getRole($name);
		if($authManage->remove($role)){
			return $this->redirect(['rbac/roles']);
		}
	}
	/**
	 * @desc 角色分配权限
	 * @param string $name
	 * @return \yii\web\Response|string
	 */
	public function actionAssiginitem(string $name)
	{
		$name = htmlspecialchars($name);
		$auth = Yii::$app->authManager;
		$parent = $auth->getRole($name);
		if(Yii::$app->request->isPost){
			$post = Yii::$app->request->post();
			if(Rbac::addChild($post['children'],$parent)){
				return $this->showSuccess('rbac/roles');
			}
		}
		$children = Rbac::getChildrenByName($name);
		$roles = Rbac::getOptions($auth->getRoles(), $parent);
		$permissions = Rbac::getOptions($auth->getPermissions(), $parent);
		return $this->render('assiginitem',['parent'=>$parent,'roles'=>$roles,'permissions'=>$permissions,'children'=>$children,'title'=>'分配权限']);
	}
	
	
	
	
}