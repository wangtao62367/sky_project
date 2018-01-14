<?php
namespace backend\controllers;



use Yii;
use yii\web\Controller;
/**
 * @name 操作成功
 * @author wangt
 *
 */
class SuccessController extends Controller
{
    /**
     * @desc 操作成功
     * @param unknown $back
     * @return string
     */
    public function actionSuc($back)
    {
        $get = Yii::$app->request->get();
        $m = isset($get['m']) && !empty($get['m']) ? $get['m'] : 2;
        return $this->render('suc',['back'=>$back,'m'=>$m]);
    }
}