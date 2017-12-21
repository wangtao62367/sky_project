<?php
namespace backend\controllers;




use common\controllers\CommonController;

class ContentController extends CommonController
{
    
    public function actionManage()
    {
        return $this->render('manage');
    }
}