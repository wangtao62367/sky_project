<?php
namespace backend\controllers;


use Yii;
use backend\lib\Tools;
use yii\web\Controller;
/**
 * @name 公共部分
 * @author wangt
 *
 */
class DefaultController extends Controller
{
	public function init()
	{
		$isGuest = Yii::$app->user->isGuest;
		if($isGuest){
			echo "<script>window.top.location.href =('public/login');</script>";
			exit;
		}
	}
    /**
     * @desc 首页
     * @return string
     */
    public function actionIndex()
    {
        Tools::DebugToolbarOff();
        $this->layout = false;
        return $this->render('index');
    }
    
    /**
     * @desc 顶部
     * @return string
     */
    public function actionTop()
    {
        Tools::DebugToolbarOff();
        $this->layout = 'side';
        return $this->render('top');
    }
    /**
     * @desc 左侧
     * @return string
     */
    public function actionLeft()
    {
        Tools::DebugToolbarOff();
        $this->layout = 'side';
        return $this->render('left');
    }
    /**
     * @desc 右侧
     * @return unknown
     */
    public function actionMain()
    {
        $this->layout = 'main';
        return $this->render('main');
    }
}