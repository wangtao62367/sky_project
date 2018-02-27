<?php
namespace frontend\controllers;





use common\models\Schedule;
use common\models\ScheduleTable;

class ScheduleController extends CommonController
{
	
	
	public function actionInfo(int $id)
	{
		$schedule= Schedule::findOne($id);
		if(empty($schedule)){
			return false;
		}
		
		$tables = ScheduleTable::find()->orderBy('lessonDate ASC,lessonStartTime ASC,lessonEndTime ASC')->all();
		
		return $this->render('info',['schedule'=>$schedule,'tables'=>$tables]);
	}
}