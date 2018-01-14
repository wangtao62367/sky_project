<?php
namespace backend\controllers;




use common\controllers\CommonController;
/**
 * @name 内容管理
 * @author wangt
 *
 */
class ContentController extends CommonController
{
    /**
     * @desc 内容列表
     * @return string
     */
    public function actionManage()
    {
        $this->layout = 'main';
        return $this->render('manage');
    }
}