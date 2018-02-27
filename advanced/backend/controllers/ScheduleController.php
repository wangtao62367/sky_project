<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Schedule;
/**
 * @name 课表管理
 * @author wangtao
 *
 */
class ScheduleController extends CommonController
{
	/**
	 * @desc 课表列表
	 * @return string
	 */
	public function actionManage()
	{
		$schedule = new Schedule();
		
		$data = Yii::$app->request->get();
		$list = $schedule->pageList($data);
		return $this->render('manage',['model'=>$schedule,'list'=>$list]);
	}
	
	/**
	 * @desc 添加课表
	 * @return \yii\web\Response|string
	 */
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
	/**
	 * @desc 编辑课表
	 * @param unknown $id
	 * @return \yii\web\Response|string
	 */
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
	    $schedule->publishEndTime= date('Y-m-d H:i:s',$schedule->publishEndTime);
	    return $this->render('add',['model'=>$schedule,'title'=>'编辑课表']);
	}
	
	/**
	 * @desc 删除课表
	 * @param int $id
	 * @return \yii\web\Response
	 */
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
	/**
	 * @desc 批量删除课表
	 * @return number
	 */
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return Schedule::updateAll(['isDelete'=>1],['in','id',$idsArr]);
	}
	/**
	 * @desc 导出课表
	 */
	public function actionExport()
	{
	    $schedule = new Schedule();
	    
	    $data = Yii::$app->request->get();
	    $schedule->export($data);
	}
	/**
	 * @desc 快速发布课表
	 */
	public function actionPublish(int $id)
	{
	    $schedule= Schedule::findOne($id);
	    if(Yii::$app->request->isPost){
	        $post = Yii::$app->request->post();
	        if(Schedule::edit($post, $schedule)){
	            return $this->showSuccess('schedule/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$schedule->getErrorDesc());
	        }
	    }
	    $schedule->publishTime = date('Y-m-d H:i:s',$schedule->publishTime);
	    $schedule->publishEndTime= date('Y-m-d H:i:s',$schedule->publishEndTime);
	    return $this->renderAjax('publish',['model'=>$schedule]);
	}
}