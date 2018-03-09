<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$params= Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['image/manage'])?>">图片模块</a></li>
        <li><a href="<?php echo $url;?>">编辑导航</a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span>编辑导航</span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">

	<li><label>导航名称</label><?php echo Html::activeTextInput($model, 'codeDesc',['class'=>'dfinput'])?><i>名称只能是2到5个字</i></li>
    <li><label>排序</label><?php echo Html::activeTextInput($model, 'sorts',['class'=>'dfinput'])?><i>数字越小越靠前</i></li>
	<?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>