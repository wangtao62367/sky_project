<?php
namespace frontend\controllers;



use Yii;
use yii\web\Controller;
use common\models\WebCfg;
use common\models\Common;
use common\models\BottomLink;

class CommonController extends Controller
{
	
	public function init()
	{
		$webCfgs = WebCfg::getWebCfg();
		$nav     = $this->getNav();
		$bottomLinks = $this->getBottomLinks();
		$view = Yii::$app->view;
		$view->params['webCfgs'] = $webCfgs;
		$view->params['nav'] = $nav;
		$view->params['bootomLinks'] = $bottomLinks;
	}
	
	public function getNav()
	{
		$commonMolde = new Common();
		return $commonMolde->getNav();
	}
	
	public function getBottomLinks()
	{
	    $data = [];
	    $bottomLinkCates = Common::getCommonListByType('bottomLink');
	    foreach ($bottomLinkCates as $cate){
	        $bottomlinks = BottomLink::find()->select([
	            'id',
	            'linkName',
	            'linkUrl',
	            'linkCateId'
	        ])->where(['linkCateId'=>$cate['id']])->orderBy('modifyTime desc')->all();
	        $data[$cate['code']] = [
	            'codeDesc' => $cate['codeDesc'],
	            'list' => $bottomlinks
	        ];
	    }
	    return $data;
	}
}

