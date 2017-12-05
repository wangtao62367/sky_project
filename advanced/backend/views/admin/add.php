<?php

use yii\helpers\Html;
use backend\assets\AppAsset;

$this->title="添加管理员";
?>
<p style="color: red;font-size:14px">
	<?php if(Yii::$app->session->hasFlash('error')){ echo Yii::$app->session->getFlash('error');} ?>
	<?php if(Yii::$app->session->hasFlash('success')){ echo Yii::$app->session->getFlash('success');} ?>
</p>
<?php echo Html::beginForm();?>
<div class="form-group form-account">
	<div class="form-lable"><?php echo Html::label('管理员账号：','account');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'account',[
    	    'placeholder'=>'请输入管理员账号(3-20字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group form-adminPwd">
	<div class="form-lable"><?php echo Html::label('管理员密码：','adminPwd')?></div>
	<div class="form-input">
		<?php echo Html::activePasswordInput($model, 'adminPwd',[
    	    'placeholder'=>'请输入管理员密码(3-40字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group form-repass">
	<div class="form-lable"><?php echo Html::label('重复输密码：','repass')?></div>
	<div class="form-input repass">
		<?php echo Html::activePasswordInput($model, 'repass',[
    	    'placeholder'=>'请输入重复密码',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group form-adminEmail">
	<div class="form-lable"><?php echo Html::label('管理员邮箱：','adminEmail')?></div>
	<div class="form-input">
		<?php 
		echo Html::activeTextInput($model, 'adminEmail',[
		    'placeholder'=>'请输入管理员邮箱',
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

