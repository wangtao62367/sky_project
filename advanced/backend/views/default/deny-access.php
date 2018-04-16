<?php
use yii\helpers\Url;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="<?php echo Url::to(['default/main'])?>">控制台</a></li>
        <li><a href="javascript:;">限制访问</a></li>
    </ul>
</div>

<p style="padding: 30px">对不起！您没有访问权限。如有疑问，请联系系统管理员</p>