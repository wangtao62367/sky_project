<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LoginAsset;

?>

<div class="landing-box">
	<h4>用户注册</h4>
	<?php echo Html::beginForm('','post',['id'=>"login_form","autocomplete"=>"off"]);?>
	<div class="field">
		<label>用户账号：</label>
		<?php echo Html::activeTextInput($model, 'account',['placeholder'=>'用户账号长度为3-20个字','class'=>'textbox']);?><i>*</i>
	</div>
	<div class="field">
		<label>用户邮箱：</label>
		<?php echo Html::activeTextInput($model, 'email',['placeholder'=>'用户邮箱不能为空','class'=>'textbox']);?><i>*</i>
	</div>
	<div class="field">
		<label>用户手机：</label>
		<?php echo Html::activeTextInput($model, 'phone',['placeholder'=>'用户手机号','class'=>'textbox']);?>
	</div>
	<div class="field ">
		<label>用户密码：</label>
		<?php echo Html::activePasswordInput($model, 'userPwd',['placeholder'=>'密码必须由6至16位的字母+数字组成','class'=>'pwbox',"autocomplete"=>"off"]);?><i>*</i>
	</div>
	<div class="field">
		<label>确认密码：</label>
		<?php echo Html::activePasswordInput($model, 'repass',['placeholder'=>'确认密码','class'=>'pwbox',"autocomplete"=>"off"]);?><i>*</i>
	</div>
	<p class="form-error"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
	<input type="submit" value="注册" class="bt">
	<?php echo Html::endForm();?>
	<span>已有账户，点此<a href="<?php echo Url::to(['user/login']);?>">登录</a></span>
</div>
<?php 
LoginAsset::addCss($this, '/front/css/registration.css');
?>
		

