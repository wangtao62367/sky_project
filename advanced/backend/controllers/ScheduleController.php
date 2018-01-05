<?php
namespace backend\controllers;


use Yii;
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
		
		$data = Yii::$app->request->get();
		$list = $schedule->pageList($data);
		return $this->render('manage',['model'=>$schedule,'list'=>$list]);
	}
	
	
	public function actionAdd()
	{
	    $schedule = new Schedule();
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = $schedule->add($data);
	        if($result){
	            return $this->showSuccess('schedule/manage');
	        }
	        Yii::$app->session->setFlash('error',$schedule->getErrorDesc());
	    }
	    
	    return $this->render('add',['model'=>$schedule,'title'=>'添加课表']);
	}
}