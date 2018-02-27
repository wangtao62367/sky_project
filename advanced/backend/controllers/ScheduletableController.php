<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\ScheduleTable;
use common\models\Schedule;
/**
 * @name 课表课程管理
 * @author wangtao
 *
 */
class ScheduletableController extends CommonController
{
	
	/**
	 * @desc 添加课表课程
	 * @return \yii\web\Response|string
	 */
	public function actionAdd(int $sid)
	{
		$schedule= Schedule::findOne($sid);
		if(empty($schedule)){
			return $this->showDataIsNull('schedule/manage');
		}
		$model = new ScheduleTable();
		if(Yii::$app->request->isPost){
			$data = Yii::$app->request->post();
			$result = $model->add($data);
			if(!$result){
				Yii::$app->session->setFlash('error',$model->getErrorDesc());
			}else{
				return $this->showSuccess('schedule/info?id='.$sid);
			}
		}
		return $this->render('add',['schedule'=>$schedule,'model'=>$model,'title'=>'添加课表课程']);
	}
	/**
	 * @desc 编辑课表课程
	 * @param int $id
	 * @return \yii\web\Response|string
	 */
	public function actionEdit(int $id,int $sid)
	{
		$schedule= Schedule::findOne($sid);
		if(empty($schedule)){
			return $this->showDataIsNull('schedule/manage');
		}
		$model = ScheduleTable::findOne($id);
		if(empty($model)){
			return $this->showDataIsNull('schedule/info?id='.$sid);
		}
		if(Yii::$app->request->isPost){
			$data = Yii::$app->request->post();
			if(ScheduleTable::edit($data, $model)){
				return $this->showSuccess('schedule/info?id='.$sid);
			}else{
				Yii::$app->session->setFlash('error',$model->getErrorDesc());
			}
		}
		return $this->render('add',['schedule'=>$schedule,'model'=>$model,'title'=>'编辑课表课程']);
	}
	/**
	 * @desc 删除课表课程
	 * @param int $id
	 * @return \yii\web\Response
	 */
	public function actionDel(int $id,int $sid)
	{
		$model = ScheduleTable::findOne($id);
		if(empty($model)){
			return $this->showDataIsNull('schedule/info?id='.$sid);
		}
		if(ScheduleTable::del($model)){
			return $this->showSuccess('schedule/info?id='.$sid);
		}
	}
	/**
	 * @desc 批量删除课表课程
	 * @return number
	 */
	public function actionBatchdel()
	{
		$this->setResponseJson();
		$ids = Yii::$app->request->post('ids');
		$idsArr = explode(',',trim($ids,','));
		return ScheduleTable::deleteAll(['in','id',$idsArr]);
	}
	
}