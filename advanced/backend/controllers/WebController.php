<?php
namespace backend\controllers;




use common\controllers\CommonController;
/**
 * @name 基础设置
 * @author wangt
 *
 */
class WebController extends CommonController
{
    /**
     * @desc 网站设置
     * @return string
     */
    public function actionSetting()
    {
        
        return $this->render('setting');
    }
}