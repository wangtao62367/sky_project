<?php
namespace backend\controllers;


use Yii;
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
		
		$data = Yii::$app->request->get();
		$list = $gradeClass->pageList($data);
		return $this->render('manage',['model'=>$gradeClass,'list'=>$list]);
	}
	
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
	
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return GradeClass::updateAll(['isDelete'=>GradeClass::GRADECLASS_DELETE],['in','id',$idsArr]);
	}
	
	public function actionAjaxClasses(string $keywords)
	{
	    $keywords = trim($keywords);
	    $this->setResponseJson();
	    $result = GradeClass::find()->select(['id','text'=>'className'])->where(['and',['isDelete'=>0],['like','className',$keywords]])->asArray()->all();
	    return $result;
	}
}