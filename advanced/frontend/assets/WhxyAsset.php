<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WhxyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'front/css/normalize.css',
        'front/css/whxy_layout.css',
    ];
    public $js = [
        'front/js/common.js',
        'front/js/jquery.crousle.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /* 'yii\bootstrap\BootstrapAsset', */
    ];
    
    
    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [WhxyAsset::className(), 'depends' => 'frontend\assets\WhxyAsset']);
    }
    
    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [WhxyAsset::className(), 'depends' => 'frontend\assets\WhxyAsset']);
    }  
}
