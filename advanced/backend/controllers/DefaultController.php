<?php
namespace backend\controllers;


use common\controllers\CommonController;
use backend\lib\Tools;

class DefaultController extends CommonController
{
    
    public function actionIndex()
    {
        Tools::DebugToolbarOff();
        $this->layout = false;
        return $this->render('index');
    }
    
    
    public function actionTop()
    {
        Tools::DebugToolbarOff();
        $this->layout = 'side';
        return $this->render('top');
    }
    
    public function actionLeft()
    {
        Tools::DebugToolbarOff();
        $this->layout = 'side';
        return $this->render('left');
    }
    
    public function actionMain()
    {
        $this->layout = 'main';
        return $this->render('main');
    }
}