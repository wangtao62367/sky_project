<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['bottomcate/manage'])?>">底部链接分类管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title;?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>链接分类名称<b>*</b></label><?php echo Html::activeTextInput($model, 'codeDesc',['class'=>'dfinput'])?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <?php if($oprate == 'add'):?>
    <li><label>分类标识<b>*</b></label><?php echo Html::activeTextInput($model, 'code',['class'=>'dfinput'])?><i>必须唯一性</i></li>
    <?php endif;?>
    <li><label>排序<b>*</b></label><?php echo Html::activeInput('number',$model, 'sorts',['class'=>'dfinput'])?><i>排序值越小越靠前</i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>