<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\TestPaper;

$this->title = '个人信息';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="<?php echo Url::to(['user/center']);?>">我的报名</a></li>
		
		<li><a  class="UnitedFront">个人信息</a></li>
		
		<li><a href="<?php echo Url::to(['user/edit-pwd']);?>" >修改密码</a></li>

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
		
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
$css = <<<CSS
.section .content ._hr {
    margin-top: -15px;
}
CSS;
$js = <<<JS

JS;
$this->registerJs($js);
$this->registerCss($css);
?>