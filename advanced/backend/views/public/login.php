<?php
use backend\assets\AppLoginAsset;
use yii\helpers\Html;
use yii\helpers\Url;
AppLoginAsset::register($this);

$this->title = '欢迎登陆';
?>
<div class="loginbody">
    <span class="systemlogo"></span>    
    <div class="loginbox">
    	<?php echo Html::beginForm()?>
	    <ul>
	    	<li>
	    		<?php echo Html::activeTextInput($model, 'account',['class'=>'loginuser','autocomplete'=>'off'])?>
	    	</li>
	    	<li>
	    		<?php echo Html::activePasswordInput($model, 'adminPwd',['class'=>'loginpwd','autocomplete'=>'off'])?>
	    	</li>
	    	<li>
	    		<?php echo Html::submitInput('登陆',['class'=>'loginbtn'])?>
	    		<label><?php echo Html::a('忘记密码？',Url::to(['public/forgetpwd']))?></label>
	    	</li>
	    </ul>
	    <?php echo Html::endForm();?>  
    </div>
</div>
<?php 
$js = <<<JS
$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    	$('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	})  
}); 
JS;
$css = <<<CSS
input:focus{background:red}

CSS;
$this->registerJs($js);
?>