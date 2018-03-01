<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__frontendid',
            'identityCookie' => ['name' => '_identity-sky-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'sky-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
    	'urlManager' => [
    		'enablePrettyUrl' => true,
    		'showScriptName' => false,
    		'enableStrictParsing' => false,
    		'suffix' => '.html',
    		'rules' => [
    			'index' => 'site/index',
    			'<pcode:\w+>/<pid:\d+>/<cateid:\d+>' => 'news/list',
    			'detail/<id:\d+>' => 'news/detail',
    			'<code:\w+>' => 'news/list-by-catecode',
    			'login' => 'user/login',
    			'logout' => 'user/logout',
    			'regis'   => 'user/reg',
    			'smail'   => 'user/findpwdbymail',
    			'center'  => 'user/center',
    			'info'    => 'user/info',
    			'edpwd'   => 'user/edit-pwd',
    			//我要报名
    			'joinup/<cid:\d+>' => 'student/joinup',
    			//课表详情
    			'schedule/<id:\d+>' => 'schedule/info',
    			//投票调查
    			'naire/<id:\d+>' => 'student/naire',
    			//试卷测评
    			'paper/<cid:\d+>' => 'student/testpapers',
    		],
    	]   
    ],
    'params' => $params,
];
