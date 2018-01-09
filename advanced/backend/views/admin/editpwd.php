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
        <li><a href="<?php echo Url::to(['default/main'])?>">首页</a></li>
        <li><a href="<?php echo Url::to(['admin/manage'])?>">管理员管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>原密码</label><?php echo Html::activePasswordInput($model, 'oldPwd',['class'=>'dfinput','placeholder'=>'输入原密码'])?></li>
    <li><label>新密码</label><?php echo Html::activePasswordInput($model, 'adminPwd',['class'=>'dfinput','placeholder'=>'输入新密码'])?></li>
    <li><label>确认密码</label><?php echo Html::activePasswordInput($model, 'repass',['class'=>'dfinput','placeholder'=>'确认密码'])?><i></i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>