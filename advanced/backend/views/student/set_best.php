<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户管理系统</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<?php echo Html::activeHiddenInput($model, 'studentId', ['value'=>$info->id])?>
<ul class="forminfo">
    <li><label>学员姓名<b>*</b></label>
    <?php echo Html::textInput('stuName',$info->trueName,['class'=>'dfinput','readonly'=>true])?></li>
    <li><label>学员头像<b>*</b></label>
    	<div href="javascript:;" class="image-box">
        	<?php if($info->avater):?>
        		<img alt="" width="100px" height="100px" src="<?php echo $info->avater;?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
    </li>
    <li><label>优秀学员简介</label><?php echo Html::activeTextarea($model, 'stuIntroduce',['class'=>'textinput'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
.image-box {
    width: 100px;
    height: 100px;
    line-height: 100px;
    display: block;
    text-align: center;
    border: 1px solid #666;
    border-style: dotted;
    margin-top: 10px;
    margin-left: 0px; 
    overflow: hidden; 
}
CSS;
AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerCss($css);
?>