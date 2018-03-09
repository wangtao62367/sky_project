<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\ScheduleTable;
use common\models\Schedule;
use common\models\Curriculum;
use yii\helpers\ArrayHelper;
use common\models\Teacher;
use common\models\TeachPlace;
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
			$data = Yii::$app->request->post();;
			$model->scheduleId = $schedule->id;
			$result = $model->add($data);
			if(!$result){
				Yii::$app->session->setFlash('error',$model->getErrorDesc());
			}else{
				return $this->showSuccess('schedule/info?id='.$sid);
			}
		}
		//获取一年内的可用课程
		$curriculumList =Curriculum::find()->select(['id','text'])->where('isDelete = 0 and (modifyTime + 31536000) > :time',[':time'=>time()])->orderBy('modifyTime DESC')->all();
		
		return $this->render('add',['schedule'=>$schedule,'model'=>$model,'curriculumList'=>$curriculumList,'teachers'=>[],'places'=>[],'title'=>'添加课表课程']);
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
		$model->scheduleId = $schedule->id;
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
		//获取一年内的可用课程
		$curriculumList =Curriculum::find()->select(['id','text'])->where('isDelete = 0 and (modifyTime + 31536000) > :time',[':time'=>time()])->orderBy('modifyTime DESC')->all();
		//获取当前时间已安排的课表信息
		$teachers = Teacher::find()->select(['id','trueName','teachTopics'])->where(['isDelete'=>0])->orderBy('modifyTime desc')->asArray()->all();
		$places = TeachPlace::find()->select(['id','text'])->where(['isDelete'=>0])->orderBy('modifyTime desc')->asArray()->all();
		return $this->render('add',['schedule'=>$schedule,'model'=>$model,'curriculumList'=>$curriculumList,'teachers'=>$teachers,'places'=>$places,'title'=>'编辑课表课程']);
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
	
	/**
	 * @desc 获取空闲教师和教学地点
	 * @return array[]|\yii\db\ActiveRecord[][]
	 */
	public function actionTeachersPlaces()
	{
	    $this->setResponseJson();
	    $lessDate = Yii::$app->request->get('lessonDate');
	    $lessonStartTime = Yii::$app->request->get('lessonStartTime');
	    $lessonEndTime = Yii::$app->request->get('lessonEndTime');
        //获取当前时间已安排的课表信息
	    list($teachers,$places) = $this->getTeachersPlaces($lessDate, $lessonStartTime, $lessonEndTime);
        return [
            'teachers' => $teachers,
            'places' => $places
        ];
	}
	
	private function getTeachersPlaces($lessDate,$lessonStartTime,$lessonEndTime)
	{
	    //获取当前时间已安排的课表信息
	    $tables = ScheduleTable::find()->select(['teacherId','teachPlaceId'])->where('lessonDate = :date AND (( lessonStartTime <= :startTime AND lessonEndTime >= :startTime ) OR ( lessonStartTime <= :endTime AND lessonEndTime >= :endTime ))',[
	        ':date' => $lessDate,
	        ':startTime' => $lessonStartTime,
	        ':endTime' => $lessonEndTime
	    ])->asArray()->all();
	    $teacherIds = ArrayHelper::getColumn($tables, 'teacherId');
	    $teachPlaceIds = ArrayHelper::getColumn($tables, 'teachPlaceId');
	    //获取可用教师和教学地点
	    $teachersQuery = Teacher::find()->select(['id','trueName','teachTopics'])->where(['isDelete'=>0])->orderBy('modifyTime desc');
	    $placeQuery = TeachPlace::find()->select(['id','text'])->where(['isDelete'=>0])->orderBy('modifyTime desc');
	    if(!empty($teacherIds)){
	        $teachersQuery = $teachersQuery->andWhere(['not in','id',$teacherIds]);
	    }
	    if(!empty($teachPlaceIds)){
	        $placeQuery= $placeQuery->andWhere(['not in','id',$teachPlaceIds]);
	    }
	    
	    $teachers = $teachersQuery->asArray()->all();
	    $places = $placeQuery->asArray()->all();
	    return [$teachers,$places];
	}
	
}