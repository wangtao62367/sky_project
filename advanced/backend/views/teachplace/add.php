<?php


use yii\helpers\Url;
use yii\helpers\Html;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['teachplace/manage'])?>">教学点管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>教学地点<b>*</b></label><?php echo Html::activeTextInput($model, 'text',['class'=>'dfinput'])?><i>教学地点不能超过10个字符</i></li>
    <li><label>详细地址</label><?php echo Html::activeTextInput($model, 'address',['class'=>'dfinput'])?></li>
    <li><label>教学点网址</label><?php echo Html::activeTextInput($model, 'website',['class'=>'dfinput'])?></li>
    <li><label>联    络    人<b>*</b></label><?php echo Html::activeTextInput($model, 'contacts',['class'=>'dfinput'])?></li>
    <li><label>联络手机<b>*</b></label><?php echo Html::activeTextInput($model, 'phone',['class'=>'dfinput'])?></li>
    <li><label>设备情况</label><?php echo Html::activeTextarea($model, 'equipRemarks',['class'=>'textinput'])?></li>
    <li><label>备    注</label><?php echo Html::activeTextarea($model, 'remarks',['class'=>'textinput'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>