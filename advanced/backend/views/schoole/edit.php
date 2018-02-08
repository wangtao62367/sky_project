<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id], $params));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['content/schoole'])?>">学院信息录入</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	<li><label>内容<b>*</b></label>
    	<div style="margin-left:86px;width:900px;height:500px" id="content" name="SchooleInformation[text]"></div>
    </li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$uploadurl = Url::to(['schoole/upload']);
$content = $model->text;
$js = <<<JS
var ue = UE.getEditor('content', {
	serverUrl : '$uploadurl',
});

 ue.ready(function() {
    ue.setContent('$content');

});

JS;
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.config.js');
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.all.min.js');
$this->registerJs($js);
?>