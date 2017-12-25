<?php
use backend\assets\AppLoginAsset;
use yii\helpers\Html;
AppLoginAsset::register($this);
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
    <style>
	   body{background-color:#1c77ac; background-image:url(/admin/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;}
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div id="mainBody">
  <div id="cloud1" class="cloud"></div>
  <div id="cloud2" class="cloud"></div>
</div>  
<div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>    
    <ul>
    <li><a href="#">回首页</a></li>
    <!--<li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>-->
    </ul>    
</div>
<?php echo $content; ?>
<div class="loginbm">版权所有  成都趣胤网络科技有限公司</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

