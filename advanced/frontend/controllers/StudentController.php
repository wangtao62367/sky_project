<?php
namespace frontend\controllers;



use Yii;
use common\models\TestPaper;


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
    
    public function actionJoinup(int $cid)
    {
        
    }
    
    public function actionTestpapers(int $cid)
    {
        $testPaper = new  TestPaper();
        $testPaper->pageSize = 15;
        $data = Yii::$app->request->get();
        $data['TestPaper']['search'] = [
            'gradeClassId' => $cid
        ];
        $list = $testPaper->getPageList($data, $data);
        return $this->render('testpapers',['list'=>$list]);
    }
    
    
    public function actionAnswer(int $id)
    {
        $testPaper = new TestPaper();
        $info = $testPaper->getInfoById($id);
        if(Yii::$app->request->isPost){
        	$post = Yii::$app->request->post();
        	
        }
        var_dump($info);
    }
    
}