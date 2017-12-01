<?php
namespace common\controllers;


use Yii;
use yii\web\Controller;


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

    
    public function init()
    {
        
    }
    
    protected function setResponseJson()
    {
        Yii::$app->response->format = 'json';
    }
    
}