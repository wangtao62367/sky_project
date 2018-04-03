<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\assets\AppAsset;


$controller = Yii::$app->controller;
$query = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id], $query));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户管理系统</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员管理</a></li>
        <li><a href="<?php echo $url;?>">打印结业证书</a></li>
    </ul>
</div>

<div class="rightinfo">

	<div id="printArea">
		
		<div class="certificate">
			
		</div>
		
	</div>

</div>

<?php 

AppAsset::addCss($this, '/admin/css/certificate.css');
?>