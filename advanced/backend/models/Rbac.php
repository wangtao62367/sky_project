<?php
namespace backend\models;


use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Rbac extends ActiveRecord
{
	
	
	public static function getOptions($data,$parent)
	{
		$retuen = [];
		foreach ($data as $obj){
			if(!empty($parent) && $parent->name != $obj->name && Yii::$app->authManager->canAddChild($parent, $obj)){
				$retuen[$obj->name] = $obj->description;
			}
			if(is_null($parent)){
				$retuen[$obj->name] = $obj->description;
			}
		}
		return $retuen;
	}
	
	public static function addChild($children,$parent)
	{
		$auth = Yii::$app->authManager;
		$tran = Yii::$app->db->beginTransaction();
		try {
			$auth->removeChildren($parent);
			foreach ($children as $item){
				$child = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
				$auth->addChild($parent, $child);
			}
			$tran->commit();
		} catch (Exception $e) {
			$tran->rollBack();
			return false;
		}
		return true;
	}
	
	public static function getChildrenByName($name)
	{
		if(empty($name)) return [];
		$return = [
				'roles' => [],
				'permissions' =>[]
		];
		$auth = Yii::$app->authManager;
		$children = $auth->getChildren($name);
		foreach ($children as $obj){
			if($obj->type == 1){
				$return['roles'][] = $obj->name;
			}else{
				$return['permissions'][] = $obj->name;
			}
		}
		return $return;
	}
	
	public static function getChildrenByUser($adminId)
	{
		if(empty($adminId)) return [];
		$return = [
				'roles' => [],
				'permissions' =>[]
		];
		$auth = Yii::$app->authManager;
		$roles = $auth->getRolesByUser($adminId);
		foreach ($roles as $obj){
			$return['roles'][] = $obj->name;
		}
		$permissions = $auth->getPermissionsByUser($adminId);
		foreach ($permissions as $obj){
			$return['permissions'][] = $obj->name;
		}
		return $return;
	}
	
	public static function grant($adminId,$children)
	{
		$auth = Yii::$app->authManager;
		$tran = Yii::$app->db->beginTransaction();
		try {
			$auth->revokeAll($adminId);
			foreach ($children as $item){
				$child = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
				$auth->assign($child, $adminId);
			}
			$tran->commit();
		} catch (Exception $e) {
			$tran->rollBack();
			return false;
		}
		return true;
	}
}