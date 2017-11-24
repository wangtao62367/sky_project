<?php
namespace backend\controllers;


use common\controllers\CommonController;

class DefaultController extends CommonController
{
    
    public function actionIndex()
    {
        
        return $this->render('index');
    }
}