<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LoginAsset;

?>

<div class="landing-box">
	<h4>找回密码</h4>
	<?php echo Html::beginForm('','post',['id'=>"login_form","autocomplete"=>"off"]);?>
	<div class="field">
		<label></label>
		<?php echo Html::activeTextInput($model, 'email',['placeholder'=>'用户邮箱地址','class'=>'textbox']);?>
	</div>
	<p class="form-error"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
	<p class="form-success"><?php if(Yii::$app->session->hasFlash('success')){echo Yii::$app->session->getFlash('success');}?></p>
	<input type="submit" value="发送邮件" class="bt">
	<?php echo Html::endForm();?>
	<span>立即返回<a href="<?php echo Url::to(['user/login']);?>">登录</a></span>
</div>
<?php 
LoginAsset::addCss($this, '/front/css/findpwdbymail.css');

?>
		

