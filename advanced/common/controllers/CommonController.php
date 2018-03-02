<?php
namespace common\controllers;


use Yii;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;
use yii\helpers\Url;


class CommonController extends Controller
{
	   
//     protected $actions = ['*'];
//     protected $except = [];
//     protected $mustlogin = [];
//     protected $verbs = [];
    
//     public function behaviors()
//     {
//         return [
//             'access' => [
//                 'class' => \yii\filters\AccessControl::className(),
//                 'only' => $this->actions,
//                 'except' => $this->except,
//                 'rules' => [
//                     [
//                         'allow' => false,
//                         'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
//                         'roles' => ['?'], // guest
//                     ],
//                     [
//                         'allow' => true,
//                         'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
//                         'roles' => ['@'],
//                     ],
//                 ],
//             ],
//             'verbs' => [
//                 'class' => \yii\filters\VerbFilter::className(),
//                 'actions' => $this->verbs,
//             ],
//         ];
//     }

	
	public function beforeAction($action)
	{
		if(!parent::beforeAction($action)){
			false;
		}
		$controller = $action->controller->id;
		$actionName = $action->id;
		if(Yii::$app->user->can($controller.'/*')){
			return true;
		}
		if(Yii::$app->user->can($controller.'/'.$actionName)){
			return true;
		}
		//throw new UnauthorizedHttpException('对不起，您没有访问权限。请联系系统管理员');
		return true;
	}

    
    public function init()
    {
    	$this->layout = 'main';
    	$isGuest = Yii::$app->user->isGuest;
    	if($isGuest){
    		echo "<script>window.top.location.href =('/public/login');</script>";
    		exit;
    	}
    }
    
    protected function setResponseJson()
    {
        Yii::$app->response->format = 'json';
    }
    
    protected function showSuccess($back)
    {
        return $this->redirect(['success/suc','back'=>$back]);
    }
    
    protected function showDataIsNull($back)
    {
        return $this->redirect(['error/dataisnull','url'=>$back]);
    }
    
}