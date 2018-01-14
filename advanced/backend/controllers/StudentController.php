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
}