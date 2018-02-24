<?php
namespace frontend\controllers;



use Yii;
use common\models\TestPaper;
use frontend\logic\StudentLogic;
use common\models\Student;
use common\models\BmRecord;
use common\models\GradeClass;
use common\publics\ImageUpload;


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
            
        }
        //查看当前班级已经报名的信息
        $userId = Yii::$app->user->id;
        $bmRecords = BmRecord::find()->select('id,userId,verify')->where(['gradeClassId'=>$gradeClass->id])->asArray()->all();

        if(!empty($bmRecords)){
            $verifyCounts = array_count_values(array_column($bmRecords,"verify"));
            $sum = isset($verifyCounts[3]) ? $verifyCounts[3] : 0;
            //班级人数已满
            if($gradeClass->classSize <= $sum){
                
            }
            //判断是否已经报过名
            $userIds = array_column($bmRecords,"userId");
            if(in_array($userId, $userIds)){
                return $this->redirect(['student/info','uid'=>$userId]);
            }
        }
        //查看当前用户基本信息
        $model = Student::findOne(['userId'=>$userId]);
        if(empty($model)){
            $model = new Student();
        }
        $model->gradeClassId = $gradeClass->id;
        $model->gradeClass = $gradeClass->className;
        $model->sex = 1;
        if(Yii::$app->request->isPost){
        	$post = Yii::$app->request->post();
        	//先上传图片 再写数据
        	if(isset($_FILES['avater']) && !empty($_FILES['avater']) && !empty($_FILES['avater']['tmp_name']) ){
        	    
        	    $upload = new ImageUpload([
        	        'imageMaxSize' => 1024*50,
        	        'imagePath'    => 'avater',
        	        'isWatermark'  => false,
        	        /* 'isThumbnail'  => true,
        	        'thumbnails'   => [
        	            ['w'=>120,'h'=>120]
        	        ] */
        	    ]);
        	    $result = $upload->Upload('avater');
        	    $imageName = Yii::$app->params['oss']['host'].$result;
        	    $post['Student']['avater'] = $imageName;
        	    //并且删除老的头像
        	    if(!empty($model->avater)){
        	        $block = str_replace(Yii::$app->params['oss']['host'], '', $model->avater);
        	        $upload->deleteImage($block);
        	    }
        	}
        	$result = Student::add($post,$model);
        	if($result){
        	    return $this->redirect(['student/info','uid'=>$userId]);
        	}else{
        	    Yii::$app->session->setFlash('error',$model->getErrors());
        	}
        }
        return $this->render('joinup',['model'=>$model,'gradeClass'=>$gradeClass]);
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