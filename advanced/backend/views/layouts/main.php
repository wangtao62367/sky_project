<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

// use yii\bootstrap\Nav;
// use yii\bootstrap\NavBar;
// use yii\widgets\Breadcrumbs;
// use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode('社会主义学院后台管理-' . $this->title); ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="top">
	<img  src="admin/img/logo.png"/>
	<span>四川省社会主义后台管理系统</span>
	<span class="login-out">
		<a href="javascript:;">切换账号</a>
		<a href="javascript:showDialog();" >退出</a>
	</span>
</div>
<div class="left">
	<ul class="nav">
		<li class="nav-memu">
			<a class="nav-memu-title" href="#">系统管理<i class="ico_down"></i></a>
			<ul style="display: none;">
				<li><a class="nav-memu-item active" href="#" onclick="showDialog(300,200)">菜单一 </a></li>
			</ul>
		</li>
		<li class="nav-memu">
			<a class="nav-memu-title" href="#">网站管理<i class="ico_down"></i></a>
			<ul style="display: none;">
				<li><a class="nav-memu-item" href="<?php echo Url::to(['vote/votes']);?>">投票管理</a></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content">
	<?php echo $content; ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
