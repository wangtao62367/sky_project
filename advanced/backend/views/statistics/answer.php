<?php

use yii\helpers\Url;
use backend\assets\AppAsset;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">统计系统</a></li>
        <li><a href="<?php echo Url::to(['statistics/answer'])?>">答题统计</a></li>
    </ul>
</div>

<div class="rightinfo">

<h4>开发中...</h4>

</div>

<?php 
AppAsset::addScript($this, '/admin/js/echarts.common.min.js');
$js = <<<JS


JS;
$this->registerJs($js);
?>