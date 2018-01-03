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
        <li><a href="<?php echo Url::to(['teacher/manage'])?>">教师管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>教师名称</label><?php echo Html::activeTextInput($model, 'trueName',['class'=>'dfinput'])?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <li><label>性&nbsp;&nbsp;别</label><?php echo Html::activeRadioList($model, 'sex', ['1'=>'男','2'=>'女'])?></li>
    <li><label>教师职称</label><?php echo Html::activeTextarea($model, 'positionalTitles',['class'=>'textinput'])?><i>教师职称不能为空，且描述长度为2-50个字。例如：高级教师、教学主任等等</i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>