<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
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
    		
    ],
    'params' => $params,
];
