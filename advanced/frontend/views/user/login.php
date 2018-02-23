<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LoginAsset;

?>

<div class="landing-box">
	<h4>用户登陆</h4>
	<?php echo Html::beginForm('','post',['id'=>"login_form","autocomplete"=>"off"]);?>
	<div class="field field-account">
		<label></label>
		<?php echo Html::activeTextInput($model, 'userName',['placeholder'=>'会员名/邮箱/手机号','class'=>'textbox']);?>
	</div>
	<div class="field field-password">
		<label></label>
		<?php echo Html::activePasswordInput($model, 'userPwd',['placeholder'=>'会员密码','class'=>'pwbox',"autocomplete"=>"off"]);?>
	</div>
	<p class="form-error"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
	<input type="submit" value="登录" class="bt">
	<?php echo Html::endForm();?>
	<a href="<?php echo Url::to(['user/findpwdbymail']);?>">忘记密码</a>
	<a href="<?php echo Url::to(['user/reg']);?>">免费注册</a>
</div>
<?php 
LoginAsset::addCss($this, '/front/css/landing.css');

?>
		

