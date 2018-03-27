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
    	<div class="toole-logo-box">
    		<div class="tools">
    			<div class="left weather-box">
    				<span><span id="currentdata">2017年03月19号</span>&nbsp;&nbsp;<span id="weather">多云转晴</span></span>
    				<span class=""><a href="javascript:;" class="addcollection">加入收藏</a>&nbsp;|&nbsp;<a href="javascript:;" class="setindex">设为首页</a></span>
    			</div>
    			<div class="right search-box">
    				<?php echo  Html::beginForm(Url::to(['site/search']),'get');?>
    					<span class="search-text"><?php echo Html::activeTextInput($params['searchModel'],'search[keywords]');?><?php echo Html::submitButton('')?></span>
    				<?php echo Html::endForm();?>
    				<div class="login-reg-box">
    					<?php if(Yii::$app->user->isGuest):?>
    					<a href="<?php echo Url::to(['user/login']);?>">登录</a> | <a href="<?php echo Url::to(['user/reg']);?>">注册</a>
    					<?php else :?>
    					欢迎您，<a href="<?php echo Url::to(['user/center']);?>"><?php echo Yii::$app->user->identity->account;?></a> | <a href="<?php echo Url::to(['user/logout']);?>">退出</a>
    					<?php endif;?>
    				</div>
    			</div>
    		</div>
    		<img class="logo" src="<?php echo $params['webCfgs']['logo'] ? $params['webCfgs']['logo']: '/front/img/index/logo_v2.png';?>" alt="logo" />
    	</div>
    	<div class="nav">
    		<ul>
    			<li><a <?php if(!isset($params['pid'])){echo 'class="active"';}?>   href="<?php echo Url::to(['site/index'])?>">学院首页</a></li>
    			<?php foreach ($params['nav'] as $v):?>
    			<li>
    				<a <?php if(isset($params['pid']) && $params['pid'] == $v['id']){echo 'class="active"';}?> href="<?php echo Url::to(['news/list','pid'=>$v['id'],'cateid'=>0,'pcode'=>$v['code']])?>"><?php echo $v['codeDesc'];?></a>
        			<?php if( $v['code'] != 'whxy' ):?>
        			<ul class="nav-item">
        				<?php foreach ($v['cates'] as $cate):?>
        					<li><a href="<?php echo Url::to(['news/list','pid'=>$v['id'],'cateid'=>$cate['id'],'pcode'=>$v['code']])?>"><?php echo $cate['text'];?></a></li>
        				<?php endforeach;?>
        			</ul>
        			<?php endif;?>
    			</li>
    			<?php endforeach;?>
    		</ul>
    	</div>
    </header>
		
	<section class="section">
		<?= $content ?>
	</section>
		
	<footer class="footer">
		<p>版权所有：<?php echo $params['webCfgs']['copyRight'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;技术支持：<?php echo $params['webCfgs']['technicalSupport'];?>&nbsp;&nbsp;<?php echo $params['webCfgs']['recordNumber'];?></p>
		<p>学员地址：<?php echo $params['webCfgs']['address'];?>&nbsp;&nbsp;邮编：<?php echo $params['webCfgs']['postCodes'];?></p>
		<p>
			<!-- <img src="/front/img/index/company_icon.png"/> -->
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
section.section{
	width:auto;
	background-color:lightblue !important;
	position: relative;
	margin-top: -20px;
}
.footer{
	height:auto;
	background-color:white;
	position:relative;
	box-sizing:border-box;
	background: none;
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

