<?php

use Yii;
use yii\helpers\Html;
use backend\assets\AppAsset;

$this->title="添加管理员";

?>

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

<div class="form-group form-btn">
	<?php echo Html::submitInput('登陆',['class'=>'btn btn-primary']);?>
</div>
<?php if(Yii::$app->session->get('error')){ echo Yii::$app->session->get('error');}?>
<?php echo Html::endForm();?>