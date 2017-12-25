<?php
namespace backend\controllers;




use common\controllers\CommonController;

class ContentController extends CommonController
{
    
    public function actionManage()
    {
        $this->layout = 'main';
        return $this->render('manage');
    }
}