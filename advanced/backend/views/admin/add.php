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
        <li><a href="<?php echo Url::to(['default/main'])?>">首页</a></li>
        <li><a href="<?php echo Url::to(['admin/manage'])?>">管理员管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>管理员账号</label><?php echo Html::activeTextInput($model, 'account',ArrayHelper::merge(['class'=>'dfinput'], isset($operat) && $operat == 'edit'? ['disabled'=>true] : []) )?><i>管理员账号不能为空，且长度为3-20个字</i></li>
    <?php if(!isset($operat) || empty($operat) || $operat != 'edit'):?>
    <li><label>管理员密码</label><?php echo Html::activePasswordInput($model, 'adminPwd',['class'=>'dfinput'])?><i>密码不能为空，且必须由字母+数字+特殊字符组成</i></li>
    <li><label>确认密码</label><?php echo Html::activePasswordInput($model, 'repass',['class'=>'dfinput'])?><i></i></li>
    <?php endif;?>
    <li><label>管理员邮箱</label><?php echo Html::activeTextInput($model, 'adminEmail',['class'=>'dfinput'])?><i>邮箱不能为空</i></li>
    <li><label>状态</label><?php echo Html::activeRadioList($model, 'isFrozen', ['0'=>'激活','1'=>'冻结'])?></li>
    <li><label>所属部门</label><?php echo Html::activeTextInput($model, 'department',['class'=>'dfinput'])?><i>所属部门不能为空</i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>