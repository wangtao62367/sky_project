<?php
namespace frontend\controllers;



use Yii;
use yii\web\Controller;
use common\models\WebCfg;
use common\models\Common;
use common\models\BottomLink;
use common\models\Article;

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
        if(!empty($this->mustLogin) && in_array($action->id, $this->mustLogin))
        
        //if($action->id == 'info' || $action->id == 'center' || $action->id == 'edit-pwd'){
            
            if (Yii::$app->user->isGuest){
                return $this->redirect(['user/login']);
            }
        //}
        return true;
    }
    
	
	public function init()
	{
		$webCfgs = WebCfg::getWebCfg();
		$nav     = $this->getNav();
		$bottomLinks = $this->getBottomLinks();
		$article = new Article();
		$view = Yii::$app->view;
		$view->params['webCfgs'] = $webCfgs;
		$view->params['nav'] = $nav;
		$view->params['bootomLinks'] = $bottomLinks;
		$view->params['searchModel'] = $article;
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
	        ])->where(['linkCateId'=>$cate['id']])->orderBy('sorts asc,modifyTime desc')->all();
	        $data[$cate['code']] = [
	            'codeDesc' => $cate['codeDesc'],
	            'list' => $bottomlinks
	        ];
	    }
	    return $data;
	}
	
	protected function setResponseJson()
	{
	    Yii::$app->response->format = 'json';
	}
}

