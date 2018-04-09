<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;


?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['web/setting'])?>">网站基础设置</a></li>
    </ul>
</div>

<div class="formbody">
<div class="formtitle">
<a href="<?php echo Url::to(['web/setting'])?>"><span>网站基础设置</span></a>
<a href="<?php echo Url::to(['web/watermark-set'])?>"><span>图片水印设置</span></a>
<a href="javascript:;"><span class="active">缓存清理</span></a>
<a href="<?php echo Url::to(['web/indexbanner-set'])?>"><span >首页banner图设置</span></a>
</div >

<div class=""> 

<a href="<?php echo Url::to(['web/clear-cache','handle'=>'clear'])?>" class="btn">清除缓存</a>

</div>

</div>

<?php 
$css = <<<CSS
.btn{
	padding: 0px;
    height: 25px;
    line-height: 25px;
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    text-decoration: none;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
CSS;
$js = <<<JS

JS;
AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>