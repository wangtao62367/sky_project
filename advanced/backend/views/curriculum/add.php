<?php


use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['curriculum/manage'])?>">课程管理</a></li>
        <li><a href="<?php echo Url::to(['curriculum/add'])?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>课程名称</label><?php echo Html::activeTextInput($model, 'text',['class'=>'dfinput'])?><i>课程名称不能为空，且长度为2-20个字</i></li>
    <li><label>是否必修</label><?php echo Html::activeRadioList($model, 'isRequired', ['0'=>'否','1'=>'是'])?></li>
    <li><label>课时数</label><?php echo Html::activeTextInput($model, 'period',['class'=>'dfinput'])?><i>课时数不能我空</i></li>
    <li><label>备&nbsp;&nbsp;注</label><?php echo Html::activeTextarea($model, 'remarks',['class'=>'textinput'])?><i></i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>