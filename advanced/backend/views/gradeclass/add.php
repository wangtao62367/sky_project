<?php


use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['teachplace/manage'])?>">班级管理</a></li>
        <li><a href="<?php echo Url::to(['teachplace/add'])?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>班级名称</label><?php echo Html::activeTextInput($model, 'className',['class'=>'dfinput'])?><i>班级名称长度为2-20个字</i></li>
    <li><label>班级人数</label><?php echo Html::activeTextInput($model, 'classSize',['class'=>'dfinput'])?><i>班级人数5-60人</i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>