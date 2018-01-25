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
    <li><label>教师姓名<b>*</b></label><?php echo Html::activeTextInput($model, 'trueName',['class'=>'dfinput'])?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <li><label>性&nbsp;&nbsp;别<b>*</b></label><?php echo Html::activeRadioList($model, 'sex', ['1'=>'男','2'=>'女'])?></li>
    <li><label>教师职称<b>*</b></label><?php echo Html::activeTextInput($model, 'positionalTitles',['class'=>'dfinput'])?><i>教师职称不能为空，且描述长度为2-50个字。例如：高级教师、教学主任等等</i></li>
    <li><label>手  机   号<b>*</b></label><?php echo Html::activeTextInput($model, 'phone',['class'=>'dfinput'])?><i>手机号不能为空</i></li>
    <li><label>行政职务<b>*</b></label><?php echo Html::activeTextInput($model, 'duties',['class'=>'dfinput'])?></li>
    <li><label>来源情况<b>*</b></label><?php echo Html::activeTextInput($model, 'from',['class'=>'dfinput'])?></li>
    <li><label>授课专题<b>*</b></label><?php echo Html::activeTextarea($model, 'teachTopics',['class'=>'textinput'])?></li>
    <li><label>研究领域</label><?php echo Html::activeTextarea($model, 'studyField',['class'=>'textinput'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>