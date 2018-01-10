<?php
namespace backend\controllers;





use Yii;
use common\controllers\CommonController;
use common\models\Student;
/**
 * 学员管理
 * @author wt
 *
 */
class StudentController extends CommonController
{
    
    
    public function actionManage()
    {
        $model = new Student();
        $data = Yii::$app->request->get();
        $list = $model->pageList($data);
        return $this->render('manage',['model'=>$model,'list'=>$list]);
        
    }
}