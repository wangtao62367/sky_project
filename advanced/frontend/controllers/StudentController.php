<?php
namespace frontend\controllers;



use Yii;
use common\models\TestPaper;
use frontend\logic\StudentLogic;
use common\models\Student;


class StudentController extends CommonController
{
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (Yii::$app->user->isGuest){
            return $this->redirect(['user/login']);
        }
        
        return true;
    }
    /**
     * 我要报名
     * @param int $cid
     */
    public function actionJoinup(int $cid)
    {
        //查看是否已经报过名
        $student = Student::find()->select('id')->where(['gradeClassId'=>$cid])->one();
        if(!empty($student)){
        	return $this->redirect(['student/info','id'=>$student->id]);
        }
        $model = new Student();
        $model->gradeClassId = $cid;
        if(Yii::$app->request->isPost){
        	$post = Yii::$app->request->post();
        	
        }
        return $this->render('joinup',['model'=>$model]);
    }
    
    public function actionTestpapers(int $cid)
    {
        $testPaper = new  TestPaper();
        $testPaper->pageSize = 15;
        $data = Yii::$app->request->get();
        $data['TestPaper']['search'] = [
            'gradeClassId' => $cid,
        	'isPublish' => 1,
        	'verify' => 1
        ];
        $list = $testPaper->getPageList($data, $data);
        return $this->render('testpapers',['list'=>$list]);
    }
    
    
    public function actionAnswer(int $id)
    {
        $testPaper = new TestPaper();
        $info = $testPaper->getInfoById($id);
        return $this->render('answer',['info'=>$info]);
    }
    
    public function actionSubmitAnswer()
    {
        $this->setResponseJson();
        $post = Yii::$app->request->post();
        
        $StudentLogic = new StudentLogic();
        if($StudentLogic->submitAnswer($post)){
        	return 1;
        }
        return 0;
    }
    
}