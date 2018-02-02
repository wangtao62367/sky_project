<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'front/css/normalize.css',
        'front/css/site.css',
    ];
    public $js = [
        'front/js/common.js',
        'front/js/jquery.crousle.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /* 'yii\bootstrap\BootstrapAsset', */
    ];
}
