<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\GradeClass;
/**
 * 班级管理
 * @author wt
 *
 */
class GradeclassController extends CommonController
{
	public function actionManage()
	{
		$gradeClass = new GradeClass();
		
		$data = ['GradeClass' => [
				'curPage' =>1,
				'pageSize' => 10
		]];
		$list = $gradeClass->pageList($data);
		return $this->render('manage',['model'=>$gradeClass,'list'=>$list]);
	}
}