<?php


use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\Url;

$this->title="登录";

?>

<?php echo Html::beginForm();?>
<div class="form-group form-account">
	<div class="form-lable"><?php echo Html::label('账&nbsp;&nbsp;号：','account');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'account',[
    	    'placeholder'=>'请输入管理员账号(3-20字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>

<div class="form-group form-adminPwd">
	<div class="form-lable"><?php echo Html::label('密&nbsp;&nbsp;码：','adminPwd')?></div>
	<div class="form-input">
		<?php echo Html::activePasswordInput($model, 'adminPwd',[
    	    'placeholder'=>'请输入管理员密码(3-40字)',
		    'autocomplete'=>'off'
    	]);?>
	</div>
</div>
<p class="error"><?php if( !empty(Yii::$app->session->get('error')) ){ echo Yii::$app->session->get('error');}?></p>

<div class="form-group form-btn">
	<?php echo Html::submitInput('登陆',['class'=>'btn btn-primary']);?>
</div>
<?php echo Html::a('忘记密码？',Url::to(['public/forgetpwd']),['title'=>'找回密码？']);?>

<?php echo Html::endForm();?>
