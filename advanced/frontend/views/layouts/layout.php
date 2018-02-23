<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\LoginAsset;
use yii\helpers\Url;

LoginAsset::register($this);
$params = $this->params;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header class="header">
    	<div class="container">
    		<div class="full-text-search">
    			
    		</div>
    		<div class="header-crousel">
    			<div class="logo">
    				<img src="<?php echo $params['webCfgs']['logo'] ? $params['webCfgs']['logo']: '/front/img/index/logo.png';?>" width="140px" />
    				<div class="logo-title">
    					<h3><?php echo $params['webCfgs']['siteName'];?></h3>
    					<h3><?php echo $params['webCfgs']['siteName2'];?></h3>
    				</div>
    			</div>
    			<!-- <div class="crousel-parent">
    				<div class="crousel">
    					<img src="/front/img/index/_001.png" width="447px" height="200px"/>
    					<img src="/front/img/index/_002.png" width="447px" height="200px"/>
    					<img src="/front/img/index/_003.png" width="447px" height="200px"/>
    				</div>
    			</div> -->
    		</div>
    	</div>
    </header>
		
	<section class="section">
		<?= $content ?>
	</section>
		
	<footer class="footer">
		<p>版权所有：<?php echo $params['webCfgs']['copyRight'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;技术支持：<?php echo $params['webCfgs']['technicalSupport'];?>&nbsp;&nbsp;<?php echo $params['webCfgs']['recordNumber'];?></p>
		<p>学员地址：<?php echo $params['webCfgs']['address'];?>&nbsp;&nbsp;邮编：<?php echo $params['webCfgs']['postCodes'];?></p>
		<p>
			<img src="/front/img/index/company_icon.png"/>
		</p>
	</footer>
<?php 
$css=<<<CSS
.header {
    height: auto;
    width: 100%;
    min-width: 1200px;
    max-width: 2000px;
    margin: 0 auto;
    background: none;
}
section{
	width:auto;
	background-color:lightblue !important;
	position: relative;
	margin-top: -20px;
}
.footer{
	height:230px;
	background-color:white;
	position:relative;
	box-sizing:border-box;
	background: #d3d2d8;
}
.footer p{
	width:1200px;
	text-align:center;
	font-weight:bold;
	margin:0 auto;
	padding-top:25px;
}
.footer .add{
	padding-top:8px;
	padding-bottom:25px;
}
.footer img{
	display:block;
	margin:0 auto;
	margin-bottom:25px;
}
CSS;
$this->registerCss($css);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

