<?php
namespace backend\controllers;





use Yii;
use common\controllers\CommonController;
use common\models\Student;
/**
 * @name 学员管理
 * @author wt
 *
 */
class StudentController extends CommonController
{
    
    /**
     * @desc 学员列表
     * @return string
     */
    public function actionManage()
    {
        $model = new Student();
        $data = Yii::$app->request->get();
        $data['Student']['search']['verify'] = 2;
        $list = $model->pageList($data);
        return $this->render('manage',['model'=>$model,'list'=>$list]);
        
    }
    /**
     * @desc 报名审核列表
     * @return string
     */
    public function actionVerifyList()
    {
        $model = new Student();
        $data = Yii::$app->request->get();
        $verify = Yii::$app->request->get('verify',0);
        $data['Student']['search']['verify'] = $verify;
        $list = $model->pageList($data);
        return $this->render('verify_list',['model'=>$model,'list'=>$list]);
    }
    /**
     * @desc 查看/审核
     */
    public function actionInfo(int $id)
    {
        $student = Student::findOne($id);
        if(empty($student)){
            return $this->showDataIsNull('student/verify-list');
        }
        return $this->render('info',['info'=>$student]);
    }
    /**
     * @desc 初始审核报名
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionVerifyOne(int $id)
    {
    	$student = Student::findOne($id);
    	if(empty($student)){
    		return $this->showDataIsNull('student/verify-list');
    	}
    	if(Yii::$app->request->isPost){
    		$isAgree = Yii::$app->request->post('isAgree');
    		$reasons1= Yii::$app->request->post('reasons1');
    		$verify = 1;
    		if(intval($isAgree) == 0){
    			$verify = 3;
    		}
    		$student->verify   = $verify;
    		$student->reasons1 = $reasons1;
    		if($student->save(false)){
    			return $this->showSuccess('student/info?id='.$id);
    		}else{
    			Yii::$app->session->setFlash('error','操作失败');
    		}
    	}
    	return $this->render('info',['info'=>$student]);
    }
    /**
     * @desc 二次审核报名
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionVerifyTwo(int $id)
    {
    	$student = Student::findOne($id);
    	if(empty($student)){
    		return $this->showDataIsNull('student/verify-list');
    	}
    	if(Yii::$app->request->isPost){
    		$isAgree = Yii::$app->request->post('isAgree');
    		$reasons2= Yii::$app->request->post('reasons2');
    		$verify = 2;
    		if(intval($isAgree) == 0){
    			$verify = 3;
    		}
    		$student->verify   = $verify;
    		$student->reasons2 = $reasons2;
    		if($student->save(false)){
    			return $this->showSuccess('student/info?id='.$id);
    		}else{
    			Yii::$app->session->setFlash('error','操作失败');
    		}
    	}
    	return $this->render('info',['info'=>$student]);
    }
    /**
     * @desc 删除学员
     * @param int $id
     * @return unknown
     */
    public function actionDel(int $id)
    {
    	$student = Student::findOne($id);
    	if(empty($student)){
    		return $this->showDataIsNull('student/verify-list');
    	}
    	if(Student::del($student)){
    		return $this->redirect(['student/manage']);
    	}
    }
    
    
}