<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\ArrayHelper;

$this->title="添加用户";
?>
<p style="color: red;font-size:14px">
	<?php if(Yii::$app->session->hasFlash('error')){ echo Yii::$app->session->getFlash('error');} ?>
	<?php if(Yii::$app->session->hasFlash('success')){ echo Yii::$app->session->getFlash('success');} ?>
</p>
<?php echo Html::beginForm();?>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('用户角色：','roleId')?></div>
	<div class="form-input cate">
		<?php echo Html::activeDropDownList($model, 'roleId', ArrayHelper::map($roles, 'id', 'roleName') , ['prompt'=>'请选择','prompt_val'=>'0','style'=>'width:100px'])?>
	</div>
</div>


<div class="form-group form-account">
	<div class="form-lable"><?php echo Html::label('用户账号：','account');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'account',[
    	    'placeholder'=>'请输入用户账号(3-20字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group">
	<div class="form-lable"><?php echo Html::label('用户密码：','userPwd')?></div>
	<div class="form-input">
		<?php echo Html::activePasswordInput($model, 'userPwd',[
    	    'placeholder'=>'请输入用户密码(3-40字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('重复密码：','repass')?></div>
	<div class="form-input repass">
		<?php echo Html::activePasswordInput($model, 'repass',[
    	    'placeholder'=>'请输入重复密码',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('用户邮箱：','email')?></div>
	<div class="form-input">
		<?php 
		echo Html::activeTextInput($model, 'email',[
		    'placeholder'=>'请输入用户邮箱',
		    'autocomplete'=>'off'
		]);
        ?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('用户手机：','phone')?></div>
	<div class="form-input">
		<?php 
		echo Html::activeTextInput($model, 'phone',[
		    'placeholder'=>'请输入用户手机号',
		    'autocomplete'=>'off'
		]);
        ?>
	</div>
</div>

<div class="form-group form-btn">
	<?php echo Html::submitInput('确认保存',['class'=>'btn btn-primary']);?>
	<?php echo Html::resetInput('清空重置',['class'=>'btn'])?>
</div>

<?php echo Html::endForm();?>

<?php 
    AppAsset::addCss($this, 'admin/css/form.css');
    $js = <<<JS

JS;
    $this->registerJs($js);
?>

