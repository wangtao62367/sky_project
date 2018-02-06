<?php


use yii\captcha\Captcha;
use yii\helpers\Html;

?>
<div class="reg-form">
	<?php echo Html::beginForm();?>
	<?php echo Html::activeTextInput($model, 'account',['placeholder'=>'输入用户账号']);?>
	
	<?php echo Html::activeTextInput($model, 'email',['placeholder'=>'输入用户邮箱']);?>
	
	<?php echo Html::activePasswordInput($model, 'userPwd',['placeholder'=>'输入用户密码']);?>
	
	<?php echo Html::activePasswordInput($model, 'repass',['placeholder'=>'确认用户密码']);?>

	<?php echo Html::activeTextInput($model, 'verifyCode',['placeholder'=>'输入验证码']);
	//我这里写的跟官方的不一样，因为我这里加了一个参数(login/captcha),这个参数指向你当前控制器名，如果不加这句，就会找到默认的site控制器上去，验证码会一直出不来，在style里是可以写css代码的，可以调试样式
	echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'user/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;margin-left:25px;'],'template'=>'{image}']);
	?>
	
	<?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?>
	
	<?php echo Html::submitInput('注册');?>
	<?php echo Html::endForm();?>
</div>

