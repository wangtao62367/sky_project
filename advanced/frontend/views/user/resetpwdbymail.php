<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LoginAsset;

?>

<div class="landing-box">
	<h4>设置新密码</h4>
	<?php echo Html::beginForm('','post',['id'=>"login_form","autocomplete"=>"off"]);?>
	<div class="field">
		<label></label>
		<?php echo Html::activePasswordInput($model, 'userPwd',['placeholder'=>'密码必须由6至16位的字母+数字组成','class'=>'textbox']);?>
	</div>
	<div class="field">
		<label></label>
		<?php echo Html::activePasswordInput($model, 'repass',['placeholder'=>'确认密码','class'=>'textbox']);?>
	</div>
	<p class="form-error"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
	<input type="submit" value="确认" class="bt">
	<?php echo Html::endForm();?>
	<span>立即返回<a href="<?php echo Url::to(['user/login']);?>">登录</a></span>
</div>
<?php 
LoginAsset::addCss($this, '/front/css/findpwdbymail.css');
$css=<<<CSS
.landing-box {height: 290px;}
CSS;
$this->registerCss($css);
?>
		

