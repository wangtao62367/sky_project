<?php
namespace backend\controllers;





use Yii;
use common\controllers\CommonController;
use common\models\Student;
use common\models\BestStudent;
use common\models\BmRecord;
use yii\db\Expression;
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
        $model = new BmRecord();
        $data = Yii::$app->request->get();
        $data['BmRecord']['search']['verify'] = 3;
        $export = Yii::$app->request->get('handle','');
        //导出操作
        if(strtolower(trim($export)) == 'export'){
            $result = $model -> exportStudent($data);
            Yii::$app->end();
        }
        
        $list = $model->pageList($data,'verify asc,modifyTime desc,createTime desc',['student','gradeclass']);
        
        return $this->render('manage',['model'=>$model,'list'=>$list]);
        
    }
    /**
     * @desc 报名审核列表
     * @return string
     */
    public function actionVerifyList()
    {
        $model = new BmRecord();
        $data = Yii::$app->request->get();
        $verify = Yii::$app->request->get('verify',1);
        $data['BmRecord']['search']['verify'] = $verify;
        $export = Yii::$app->request->get('handle','');
        //导出操作
        if(strtolower(trim($export)) == 'export'){
            $result = $model -> exportVerify($data,$verify);
            Yii::$app->end();
        }
        $list = $model->pageList($data);
        
        return $this->render('verify_list',['model'=>$model,'list'=>$list]);
    }
    /**
     * @desc 查看审核报名
     */
    public function actionInfo(int $id)
    {
        $bmRecord= BmRecord::findOne($id);
        if(empty($bmRecord)){
            return $this->showDataIsNull('student/verify-list');
        }
        
        $student = Student::findOne(['userId'=>$bmRecord->userId]);
        
        return $this->render('info',['bmRecord'=>$bmRecord,'info'=>$student]);
    }
    /**
     * @desc 初审报名
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionVerifyOne(int $id)
    {
        $bmRecord= BmRecord::findOne($id);
        if(empty($bmRecord)){
            return $this->showDataIsNull('student/verify-list');
        }
        $student = Student::findOne(['userId'=>$bmRecord->userId]);
        
    	if(Yii::$app->request->isPost){
    		$isAgree = Yii::$app->request->post('isAgree');
    		$reasons1= Yii::$app->request->post('reasons1');
    		$verify = 2;
    		if(intval($isAgree) == 0){
    			$verify = 0;
    		}
    		$bmRecord->verify   = $verify;
    		$bmRecord->verifyReason1 = $reasons1;
    		$bmRecord->verifyAdmin1  = Yii::$app->user->id;
    		$bmRecord->verifyTime1   = TIMESTAMP;
    		if($bmRecord->save(false)){
    			return $this->showSuccess('student/info?id='.$id);
    		}else{
    			Yii::$app->session->setFlash('error','操作失败');
    		}
    	}
    	return $this->render('info',['bmRecord'=>$bmRecord,'info'=>$student]);
    }
    /**
     * @desc 终审报名
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionVerifyTwo(int $id)
    {
        $bmRecord= BmRecord::findOne($id);
        if(empty($bmRecord)){
            return $this->showDataIsNull('student/verify-list');
        }
        $student = Student::findOne(['userId'=>$bmRecord->userId]);
        
        if(Yii::$app->request->isPost){
            $isAgree = Yii::$app->request->post('isAgree');
            $reasons2= Yii::$app->request->post('reasons2');
            $verify = 3;
            if(intval($isAgree) == 0){
                $verify = 0;
            }
            $bmRecord->verify   = $verify;
            $bmRecord->verifyReason2 = $reasons2;
            $bmRecord->verifyAdmin2  = Yii::$app->user->id;
            $bmRecord->verifyTime2   = TIMESTAMP;
            $bmRecord->studyNum  = date('Ymd').$student->politicalStatusCode.self::getStudyNumInGradeClass($bmRecord->gradeClassId);
            if($bmRecord->save(false)){
                return $this->showSuccess('student/info?id='.$id);
            }else{
                Yii::$app->session->setFlash('error','操作失败');
            }
        }
        return $this->render('info',['bmRecord'=>$bmRecord,'info'=>$student]);
    }
    
    private static function getStudyNumInGradeClass($gradeClassId)
    {
        $num = BmRecord::find()->select('id')->where(['gradeClassId'=>$gradeClassId,'verify'=>3])->count('DISTINCT userId');
        $num ++;
        if($num < 10){
            return '00'.$num;
        }elseif ($num < 100){
            return '0'.$num;
        }else{
            return $num;
        }
        
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
    		return $this->showDataIsNull('student/manage');
    	}
    	if(Student::del($student)){
    		return $this->redirect(['student/manage']);
    	}
    }
    
    /**
     * @desc 加入优秀学员
     * @param int $id
     * @return unknown
     */
    public function actionSetBest(int $id)
    {
        $student = Student::findOne($id);
        if(empty($student)){
            return $this->showDataIsNull('student/manage');
        }
        $model = new BestStudent();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->add($data);
            if($result){
                $student->isBest = 1;
                $student->save(false);
                return $this->showSuccess('student/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        
        return $this->render('set_best',['model'=>$model,'info'=>$student,'title'=>'设为优秀学员']);
    }
    
    /**
     * @desc 修改优秀学员
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEditBest(int $id)
    {
        $student = Student::findOne($id);
        if(empty($student)){
            return $this->showDataIsNull('student/manage');
        }
        $model = BestStudent::find()->where('studentId = :id',[':id'=>$student->id])->one();
        if(empty($model)){
            return $this->showDataIsNull('student/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = BestStudent::edit($data,$model);
            if($result){
                return $this->showSuccess('student/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('edit_best',['info'=>$student,'model'=>$model,'title'=>'修改优秀学员']);
    }
    
    public function actionPrint(int $id)
    {
        $bmRecord= BmRecord::findOne($id);
        if(empty($bmRecord)){
            return $this->showDataIsNull('student/manage');
        }
        
        return $this->render('print');
    }
    
}