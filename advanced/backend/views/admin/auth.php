<?php
use yii\helpers\Url;


?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['admin/auth'])?>">权限管理</a></li>
        <li><a href="<?php echo Url::to(['admin/auth'])?>">权限列表</a></li>
    </ul>
</div>

<div class="rightinfo">

<h4>开发中...</h4>
</div>