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
}