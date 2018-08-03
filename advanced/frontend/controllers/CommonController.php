<?php
namespace frontend\controllers;



use Yii;
use yii\web\Controller;
use common\models\WebCfg;
use common\models\Common;
use common\models\BottomLink;
use common\models\Article;
use yii\caching\DbDependency;

class CommonController extends Controller
{
    
    public $cachePages = [];
    
    public $cacheDuration = 3600;
    
    public $cacheDependcy;
    
   /*  public function behaviors()
    {
        // 声明缓存配置
        return [ // 需要注意的这里是二维数组
            [
                'class' => 'yii\filters\PageCache', // 设置需要加载的缓存文件
                'only' => $this->cachePages, // 设置需要缓存的控制器
                'duration' => $this->cacheDuration, // 设置过期时间
                'dependency' => $this->cacheDependcy
            ]
        ];
    } */
    
    public $mustLogin = [];
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if(!empty($this->mustLogin) && in_array($action->id, $this->mustLogin)){
        	if (Yii::$app->user->isGuest){
        		return $this->redirect(['user/login']);
        	}
        }
        $view = Yii::$app->view;
        if($view->params['webCfgs']['status'] == 0 && $action->id != 'closing'){
        	return $this->redirect(['site/closing'])->send();
        }elseif ($view->params['webCfgs']['status'] == 1 && $action->id == 'closing'){
            return $this->redirect(['site/index'])->send();
        }
        
        return true;
    }
    
	
	public function init()
	{
		parent::init();
		$webCfgs = $this->getWebCfg();
		$article = new Article();
		$nav     = $this->getNav();
		$bottomLinks = $this->getBottomLinks();
		$view = Yii::$app->view;
		$view->params['webCfgs'] = $webCfgs;
		$view->params['searchModel'] = $article;
		$view->params['nav'] = $nav;
		$view->params['bootomLinks'] = $bottomLinks;
	}
	
	public function getWebCfg()
	{
	    $cache = Yii::$app->cache;
	    $key = 'WEBCFG';
	    $data = $cache->get($key);
	    if(!empty($data)){
	        return $data;
	    }
	    $webCfgs = WebCfg::getWebCfg();
	    $cache->set($key, $webCfgs,null,new DbDependency(['sql'=>'SELECT GROUP_CONCAT(`value`) FROM sky_WebCfg']));
	    return $webCfgs;
	}
	
	public function getNav()
	{
	    $cache = Yii::$app->cache;
	    $key = 'NAV';
	    $data = $cache->get($key);
	    if(!empty($data)){
	        return $data;
	    }
		$commonMolde = new Common();
		$nav = $commonMolde->getNav();
		$cache->set($key, $nav,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_Common ORDER BY modifyTime DESC LIMIT 1']));
		return $nav;
	}
	
	public function getBottomLinks()
	{
	    $cache = Yii::$app->cache;
	    $key = 'BOTTOMLINKS';
	    $data = $cache->get($key);
	    if(!empty($data)){
	        return $data;
	    }
	    $data = [];
	    $bottomLinkCates = Common::getCommonListByType('bottomLink');
	    foreach ($bottomLinkCates as $cate){
	        $bottomlinks = BottomLink::find()->select([
	            'id',
	            'linkName',
	            'linkUrl',
	            'linkCateId'
	        ])->where(['linkCateId'=>$cate['id']])->orderBy('sorts asc,modifyTime desc')->all();
	        $data[$cate['code']] = [
	            'codeDesc' => $cate['codeDesc'],
	            'list' => $bottomlinks
	        ];
	    }
	    $cache->set($key, $data,null,new DbDependency(['sql'=>'SELECT modifyTime FROM sky_BottomLink order by modifyTime desc limit 1']));
	    return $data;
	}
	
	protected function setResponseJson()
	{
	    Yii::$app->response->format = 'json';
	}
}

