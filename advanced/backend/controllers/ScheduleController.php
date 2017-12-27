<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\Schedule;
/**
 * 课表管理
 * @author wangtao
 *
 */
class ScheduleController extends CommonController
{
	
	public function actionManage()
	{
		$schedule = new Schedule();
		
		$data = ['Schedule' => [
				'curPage' =>1,
				'pageSize' => 10
		]];
		$list = $schedule->pageList($data);
		return $this->render('manage',['model'=>$schedule,'list'=>$list]);
	}
}