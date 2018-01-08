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
	        var_dump($data);
	        $result = $schedule->add($data);
	        if($result){
	            return $this->showSuccess('schedule/manage');
	        }
	        Yii::$app->session->setFlash('error',$schedule->getErrorDesc());
	    }
	    
	    return $this->render('add',['model'=>$schedule,'title'=>'添加课表']);
	}
	
	public function actionEdit($id)
	{
	    $schedule = Schedule::findOne($id);
	    if(empty($schedule)){
	        return $this->showDataIsNull('schedule/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        if(Schedule::edit($data, $schedule)){
	            return $this->showSuccess('schedule/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$schedule->getErrorDesc());
	        }
	    }
	    return $this->render('add',['model'=>$schedule,'title'=>'编辑课表']);
	}
	
	
	public function actionDel(int $id)
	{
	    $schedule= Schedule::findOne($id);
	    if(empty($schedule)){
	        return $this->showDataIsNull('schedule/manage');
	    }
	    if(Schedule::del($schedule)){
	        return $this->redirect(['schedule/manage']);
	    }
	}
	
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return Schedule::updateAll(['isDelete'=>1],['in','id',$idsArr]);
	}
}