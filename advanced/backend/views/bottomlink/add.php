<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['bottomlink/manage'])?>">底部链接</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>链接名称<b>*</b></label><?php echo Html::activeTextInput($model, 'linkName',['class'=>'dfinput','placeholder'=>'链接名称不能为空，且长度为2-20个字'])?><i></i></li>
    <li><label>链接分类<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'linkCateId', ArrayHelper::map($cates,'id','codeDesc'),['prompt'=>'请选择','class'=>'sky-select'])?>
    	</div>
    </li>
    <li><label>链接地址<b>*</b></label><?php echo Html::activeTextInput($model, 'linkUrl',['class'=>'dfinput','placeholder'=>'URL地址必须是全路径;如：百度 http://www.baidu.com'])?><i></i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>