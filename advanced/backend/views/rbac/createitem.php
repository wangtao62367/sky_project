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
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['rbac/roles'])?>">权限管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>角色名称</label><?php echo Html::textInput('description',empty($role)? '':$role->description,['class'=>"dfinput"])?><i>角色名称不能为空</i></li>
    <li><label>标识</label><?php echo Html::textInput('name',empty($role)? '':$role->name,['class'=>"dfinput"])?><i>角色标识不能为空</i></li>
    <li><label>规则</label><?php echo Html::textInput('rule_name',empty($role)? '':$role->ruleName,['class'=>"dfinput"])?><i></i></li>
    <li><label>数据</label><?php echo Html::textarea('data',empty($role)? '':$role->data,['class'=>'textinput'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>