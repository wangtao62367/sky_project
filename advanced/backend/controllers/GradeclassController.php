<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\GradeClass;
use common\models\Schedule;
use yii\helpers\Url;
/**
 * @name 班级管理
 * @author wt
 *
 */
class GradeclassController extends CommonController
{
	/**
	 * @desc 班级列表
	 * @return string
	 */
	public function actionManage()
	{
		$gradeClass = new GradeClass();
		
		$data = Yii::$app->request->get();
		$list = $gradeClass->pageList($data);
		return $this->render('manage',['model'=>$gradeClass,'list'=>$list]);
	}
	/**
	 * @desc 添加班级
	 * @return \yii\web\Response|string
	 */
	public function actionAdd()
	{
	    $gradeClass = new GradeClass();
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = $gradeClass->create($data);
	        if(!$result){
	            Yii::$app->session->setFlash('error',$gradeClass->getErrorDesc());
	        }else{
	            return $this->showSuccess('gradeclass/manage');
	        }
	    }
	    return $this->render('add',['model'=>$gradeClass,'title'=>'添加班级']);
	}
	/**
	 * @desc 编辑班级
	 * @param int $id
	 * @return \yii\web\Response|string
	 */
	public function actionEdit(int $id)
	{
	    $gradeClass = GradeClass::findOne($id);
	    if(empty($gradeClass)){
	        return $this->showDataIsNull('gradeclass/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        if(GradeClass::edit($data, $gradeClass)){
	            return $this->showSuccess('gradeclass/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$gradeClass->getErrorDesc());
	        }
	    }
	    return $this->render('add',['model'=>$gradeClass,'title'=>'编辑班级']);
	}
	/**
	 * @desc 删除班级
	 * @param int $id
	 * @return \yii\web\Response
	 */
	public function actionDel(int $id)
	{
	    $gradeClass = GradeClass::findOne($id);
	    if(empty($gradeClass)){
	        return $this->showDataIsNull('gradeclass/manage');
	    }
	    if(GradeClass::del($id, $gradeClass)){
	        return $this->redirect(['gradeclass/manage']);
	    }
	}
	/**
	 * @desc 批量删除班级
	 * @return number
	 */
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return GradeClass::updateAll(['isDelete'=>GradeClass::GRADECLASS_DELETE],['in','id',$idsArr]);
	}
	/**
	 * @desc ajax获取班级列表
	 * @param string $keywords
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public function actionAjaxClasses(string $keywords)
	{
	    $keywords = trim($keywords);
	    $this->setResponseJson();
	    $result = GradeClass::find()->select(['id','text'=>'className'])->where(['and',['isDelete'=>0],['like','className',$keywords]])->asArray()->all();
	    return $result;
	}
	
	/**
	 * @desc 制作课表
	 * @param int $id
	 */
	public function actionMakeSchedule(int $id)
	{
	    $gradeClass = GradeClass::findOne($id);
	    if(empty($gradeClass)){
	        return $this->showDataIsNull('gradeclass/manage');
	    }
	    $model = new Schedule();
	    if(Yii::$app->request->isPost){
	    	$data = Yii::$app->request->post();
	    	$result = $model->add($data);
	    	if($result){
	    		return $this->showSuccess(Url::to(['schedule/manage','Schedule[search][gradeClass]'=>$gradeClass->className]));
	    	}
	    	Yii::$app->session->setFlash('error',$model->getErrorDesc());
	    }
	    
	    return $this->render('make_schedule',['model'=>$model,'className'=>$gradeClass->className,'classId'=>$gradeClass->id]); 
	}
	/**
	 * @desc 导出班级
	 */
	public function actionExport()
	{
	    $gradeClass = new GradeClass();
	    
	    $data = Yii::$app->request->get();
	    $gradeClass->export($data);
	}
}