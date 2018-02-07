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
    /**
    * @desc 学员信息录入
    * @date: 2018年2月7日 下午3:09:13
    * @author: wangtao
    * @return:
    */
    public function actionSchoole()
    {
        $this->layout = 'main';
        return $this->render('schoole');
    }
}