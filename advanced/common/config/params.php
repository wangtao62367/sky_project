<?php
$city =  require(__DIR__ . '/city_config.php');
$nation =  require(__DIR__ . '/nation_config.php');
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'citys' => $city,
    'nations' => $nation,
    'oss' => [
        'akey' => 'LTAI7mO1LDNAZqY9',
        'skey' => 'CgYQ3zFtH9jh7spCidzUCXnWNFd02g',
        'endpoint' => 'oss-cn-hangzhou.aliyuncs.com',
        'bucket' => '18upload',
        'region' => 'oss-cn-hangzhou',
        'host' => 'http://18upload.oss-cn-hangzhou.aliyuncs.com',
    ]
];
