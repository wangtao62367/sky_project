<?php
namespace backend\controllers;




use yii\web\Controller;
/**
 * @name 操作错误
 * @author wangt
 *
 */
class ErrorController extends Controller
{
    
    /**
     * @desc 数据错误
     * @param unknown $url
     * @return string
     */
    public function actionDataisnull($url)
    {
        return $this->render('dataisnull',['url'=>$url]);
    }
}