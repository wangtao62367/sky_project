<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '出错啦！！！！！！！';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        web服务器正在处理您的请求时发生上述错误。
    </p>
    <p>
                           如果您认为这是服务器错误，请与我们联系。谢谢您.
    </p>

</div>
