<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'defaultRoute' => 'public/login',
    'components' => [
    		'authManager' => [
    				'class' => 'yii\rbac\DbManager',
    				// auth_item (role permission)
    				// auth_item_child (role->permission)
    				// auth_assignment (user->role)
    				// auth_rule (rule)
    				'itemTable' => '{{%auth_item}}',
    				'itemChildTable' => '{{%auth_item_child}}',
    				'assignmentTable' => '{{%auth_assignment}}',
    				'ruleTable' => '{{%auth_rule}}',
    				'defaultRoles' => ['default'],
    		],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => false,
            'idParam'   => '__backendid',
            'identityCookie' => ['name' => '_identity-sky-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'sky-backend',
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
       
    ],
    'params' => $params,
];
