<?php
namespace frontend\controllers;



use Yii;
use common\models\TestPaper;
use frontend\logic\StudentLogic;
use common\models\Student;
use common\models\BmRecord;
use common\models\GradeClass;
use common\models\Naire;
use common\models\VoteUser;


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
        //班级信息
        $gradeClass = GradeClass::find()->select(['className','id','classSize','joinEndDate'])->where(['id'=>$cid,'isDelete'=>0])->one();
        //班级不存在、或已关闭
        if(empty($gradeClass)){
        	return $this->redirect(['news/list-by-catecode','code'=>'wybm']);
        }
        //查看当前班级已经报名的信息
        $userId = Yii::$app->user->id;
        $bmRecords = BmRecord::find()->select('id,userId,verify')->where(['gradeClassId'=>$gradeClass->id])->asArray()->all();

        if(!empty($bmRecords)){
            $verifyCounts = array_count_values(array_column($bmRecords,"verify"));
            $sum = isset($verifyCounts[3]) ? $verifyCounts[3] : 0;
            //班级人数已满
            if($gradeClass->classSize <= $sum){
            	Yii::$app->session->setFlash('error','本班人数限额已满');
            }
            //判断是否已经报过名
            $userIds = array_column($bmRecords,"userId");
            if(in_array($userId, $userIds)){
            	return $this->redirect(['user/center']);
            }
        }
        $model = new BmRecord();
        $model->gradeClassId = $gradeClass->id;
        $model->gradeClass = $gradeClass->className;
        if(Yii::$app->request->isPost){
        	$post = Yii::$app->request->post();
        	
        	$result = $model->add($post);
        	
        	if($result){
        		return $this->redirect(['user/center']);
        	}else{
        	    Yii::$app->session->setFlash('error',$model->getErrors());
        	}
        }
        return $this->render('joinup2',['model'=>$model,'gradeClass'=>$gradeClass]);
    }
    
    /**
     * 报名信息
     * @param unknown $uid
     */
    public function actionBminfo($cid)
    {
    	$bmRecord = new BmRecord();
    	$info = $bmRecord->getBmInfo([
    		BmRecord::tableName().'.userId' => Yii::$app->user->id,
    		BmRecord::tableName().'.gradeClassId' => $cid
    	]);
    	if(empty($info)){
    		return $this->redirect(['user/center']);
    	}
    	return $this->render('bminfo',['info'=>$info]);
    }
    
    
    /**
     * 班级测评试卷列表
     * @param int $cid
     * @return string
     */
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
    
    /**
     * 测试试卷
     * @param int $id
     * @return string
     */
    public function actionAnswer(int $id)
    {
        $testPaper = new TestPaper();
        $info = $testPaper->getInfoById($id);
        if(empty($info)){
        	return $this->redirect(['site/index']);
        }
        return $this->render('answer',['info'=>$info]);
    }
    /**
     * 提交测评试卷答案
     * @return number
     */
    public function actionSubmitAnswer()
    {
        $this->setResponseJson();
        $post = Yii::$app->request->post();
        //return $post;
        $StudentLogic = new StudentLogic();
        if($StudentLogic->submitAnswer($post)){
        	return 1;
        }
        return 0;
    }
    
    /**
     * 在线调查卷信息
     * @param int $id
     * @return string
     */
    public function actionNaire(int $id)
    {
    	$naire = Naire::getNaireById($id);
    	if(!$naire){
    		return $this->redirect(['site/index']);
    	}
    	//判断是否已经参与了该调查问卷
    	$isExist = (bool)VoteUser::find()->where(['naireId'=>$id,'userId'=>Yii::$app->user->id])->count('id');
    	if($isExist){
    	    return $this->render('naireinfo',['info'=>$naire]);
    	}
    	return $this->render('naire',['info'=>$naire]);
    }

    /**
     * 提交调查选项结果
     * @return number
     */
    public function actionSubmitNaire()
    {
    	$this->setResponseJson();
    	$post = Yii::$app->request->post();
    	$StudentLogic = new StudentLogic();
    	if($StudentLogic->submitNaire($post)){
    		return 1;
    	}
    	return 0;
    }
    
    
}