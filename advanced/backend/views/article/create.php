<?php


use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['article/articles'])?>">文章管理</a></li>
        <li><a href="<?php echo Url::to(['article/create'])?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>文章主题</label><?php echo Html::activeTextInput($model, 'title',['class'=>'dfinput'])?><i>文章不能为空</i></li>
    <li><label>文章摘要</label><?php echo Html::activeTextarea($model, 'summary',['class'=>'textinput'])?><i></i></li>
    <li><label>作&nbsp;&nbsp;者</label><?php echo Html::activeTextInput($model, 'author',['class'=>'dfinput'])?><i>文章作者不能为空</i></li>
    <li><label>分&nbsp;&nbsp;类</label><?php echo Html::activeDropDownList($model, 'categoryId', ['1'=>'男','2'=>'女'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>