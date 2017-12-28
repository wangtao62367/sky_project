<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;

class SuccessController extends CommonController
{
    
    public function actionSuc($back)
    {
        $get = Yii::$app->request->get();
        $m = isset($get['m']) && !empty($get['m']) ? $get['m'] : 2;
        return $this->render('suc',['back'=>$back,'m'=>$m]);
    }
}