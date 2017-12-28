<?php
namespace backend\controllers;




use common\controllers\CommonController;

class ErrorController extends CommonController
{
    
    
    public function actionDataisnull($url)
    {
        return $this->render('dataisnull',['url'=>$url]);
    }
}