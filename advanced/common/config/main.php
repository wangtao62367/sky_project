<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    		'authManager' => [
    				'class' => 'yii\rbac\DbManager',
    				// auth_item (role permission)
    				// auth_item_child (role->permission)
    				// auth_assignment (user->role)
    				// auth_rule (rule)
    				'itemTable' => '{{%AuthItem}}',
    				'itemChildTable' => '{{%AuthItemChild}}',
    				'assignmentTable' => '{{%AuthAssignment}}',
    				'ruleTable' => '{{%AuthRule}}',
    				'defaultRoles' => ['default'],
    		],
//         'urlManager' => [
//             'enablePrettyUrl' => true,
//             'showScriptName' => false,
//             'rules' => [
//             ],
//         ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
    ],
];
