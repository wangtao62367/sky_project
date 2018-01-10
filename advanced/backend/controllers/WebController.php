<?php
namespace backend\controllers;




use common\controllers\CommonController;

class WebController extends CommonController
{
    
    public function actionSetting()
    {
        
        return $this->render('setting');
    }
}