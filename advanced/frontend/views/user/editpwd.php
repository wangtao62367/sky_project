<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\TestPaper;
use yii\helpers\Html;

$this->title = '修改密码';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="<?php echo Url::to(['user/center']);?>">我的报名</a></li>
		
		<li><a href="<?php echo Url::to(['user/info']);?>" >我的信息</a></li>
		
		<li><a href="javascript:;"  class="UnitedFront">修改密码</a></li>

	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $this->title;?></h2>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<?php echo Html::beginForm('','post',['id'=>'form_editpassword','class'=>'landing-box']);?>
		
		<div class="field field-oldpwd">
			<label>旧   密   码 ：</label>
			<?php echo Html::activePasswordInput($model, 'oldPwd',['placeholder'=>'输入用户登录密码']);?>
		</div>
		
		<div class="field field-newpwd">
			<label>新   密   码 ：</label>
			<?php echo Html::activePasswordInput($model, 'newPwd',['placeholder'=>'密码必须由6至16位的字母+数字组成']);?>
		</div>
		
		<div class="field field-repass">
			<label>确认密码：</label>
			<?php echo Html::activePasswordInput($model, 'repass',['placeholder'=>'确认密码']);?>
		</div>
		
		<input type="submit" value="确认保存" class="bt">
		<?php echo Html::endForm();?>
		
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');

$css = <<<CSS
.landing-box{
	width: 394px;
    height: 530px;
	margin:0 auto;
	padding:50px;
	border-radius: 5px;
}

.landing-box .field{
	display:block;
	position: relative;
	margin-top:15px;
}

.field input{
	display:inline-block;
	margin-top:20px;
	height:40px;
	line-height:40px;
	width:300px;
	color:gray;
	border:1px solid lightgray;
	padding-left:5px;
}

.field i{
	color: red;
    margin-left: 5px;
}
.landing-box .bt{
	width:382px;
	background-color:red;
	font-size:16px;
	color:white;
	text-align:center;
	font-weight:200;
	border-radius:3px 3px 3px 3px;
	height: 40px;
    margin-top: 40px;
	outline: none;
}
.landing-box a{
    display: inline-block;
    text-align: center;
    color: #1eaff1;
    margin-top: 10px;
}

.landing-box .form-error{color:red;}
.section .content ._hr {
    margin-top: -15px;
}
CSS;
$js = <<<JS


JS;
$this->registerJs($js);
$this->registerCss($css);
?>