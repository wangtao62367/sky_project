<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\Curriculum;
/**
 * 课程管理
 * @author wangtao
 *
 */
class CurriculumController extends CommonController
{
	
	public function actionManage()
	{
		$curriculum = new Curriculum();
		$data = ['Curriculum' => [
				'curPage' =>1,
				'pageSize' => 10
		]];
		$list = $curriculum->pageList($data);
		
		return $this->render('manage',['model'=>$curriculum,'list'=>$list]);
	}
}