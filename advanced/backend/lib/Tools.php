<?php
namespace backend\lib;

use Yii;

class Tools
{
    public static function DebugToolbarOff()
    {
        if (class_exists('\yii\debug\Module')) {
            Yii::$app->view->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
        }
    }
}