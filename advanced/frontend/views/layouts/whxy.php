<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use frontend\assets\WhxyAsset;
use yii\helpers\Url;

WhxyAsset::register($this); 
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
					<?php echo  Html::beginForm(Url::to(['site/search']),'get');?>
					<span class="search-form-sp"><?php echo Html::activeTextInput($params['searchModel'],'search[keywords]');?></span>
					<span class="search-btn-sp"><?php echo Html::submitButton('搜索')?></span>
					<?php echo Html::endForm();?>
					<?php if(Yii::$app->user->isGuest):?>
					<a href="<?php echo Url::to(['user/login']);?>">登录</a> | <a href="<?php echo Url::to(['user/reg']);?>">注册</a>
					<?php else :?>
					欢迎您，<a href="<?php echo Url::to(['user/center']);?>"><?php echo Yii::$app->user->identity->account;?></a> | <a href="<?php echo Url::to(['user/logout']);?>">退出</a>
					<?php endif;?>
				</div>
				<div class="header-crousel">
					<div class="logo">
						<img src="<?php echo '/front/img/news/whxy_logo.png';?>" width="180px" />
					</div>
					<div class="crousel-parent">
						<div class="crousel">
							<img src="/front/img/index/_001.png" width="447px" height="200px"/>
							<img src="/front/img/index/_002.png" width="447px" height="200px"/>
							<img src="/front/img/index/_003.png" width="447px" height="200px"/>
						</div>
					</div>
				</div>
				<!-- 导航栏 -->
				<div class="nav">
					<ul>
						<li><a <?php if(!isset($params['pid'])){echo 'class="active"';}?>   href="<?php echo Url::to(['site/index'])?>">学院首页</a></li>
						<?php foreach ($params['nav'] as $v):?>
						<li><a <?php if(isset($params['pid']) && $params['pid'] == $v['id']){echo 'class="active"';}?> href="<?php echo Url::to(['news/list','pid'=>$v['id'],'cateid'=>0,'pcode'=>$v['code']])?>"><?php echo $v['codeDesc'];?></a>
						</li>
						<?php endforeach;?>
					</ul>
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
