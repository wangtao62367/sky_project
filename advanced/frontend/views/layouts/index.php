<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
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
    <link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/2.5.0/skins/default/aliplayer-min.css" />
     <script type="text/javascript" src="//g.alicdn.com/de/prismplayer/2.5.0/aliplayer-min.js"></script>
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
						<img src="<?php echo $params['webCfgs']['logo'] ? $params['webCfgs']['logo']: '/front/img/index/logo.png';?>" width="140px" />
						<div class="logo-title">
							<h3><?php echo $params['webCfgs']['siteName'];?></h3>
							<h3><?php echo $params['webCfgs']['siteName2'];?></h3>
						</div>
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
						<li><a  <?php if(!isset($params['pid'])){echo 'class="active"';}?>  href="<?php echo Url::to(['site/index'])?>">学院首页</a></li>
						<?php foreach ($params['nav'] as $v):?>
						<li><a <?php if(isset($params['pid']) && $params['pid'] == $v['id']){echo 'class="active"';}?> href="<?php echo Url::to(['news/list','pid'=>$v['id'],'cateid'=>0,'pcode'=>$v['code']])?>"><?php echo $v['codeDesc'];?></a>
							<ul class="nav-item" >
								<?php foreach ($v['cates'] as $cate):?>
								<li><a  href="<?php echo Url::to(['news/list','pid'=>$v['id'],'cateid'=>$cate['id'],'pcode'=>$v['code']])?>"><?php echo $cate['text'];?></a></li>
								<?php endforeach;?>
							</ul>
						</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</header>
		
		<section class="section">
			<?= $content ?>
			<!--友情链接-->
			<div class="friendship-box">
				<div class="tab">
				<?php foreach ($params['bootomLinks'] as $k=>$v):?>
					<a class="tab-title" href="javascript:;" data-targget-id = "<?php echo $k;?>"><?php echo $v['codeDesc'];?></a>
				<?php endforeach;?>
				<?php foreach ($params['bootomLinks'] as $k=>$v):?>
				<div class="link-list"  id="<?php echo $k;?>">
    					<ul>
    						<?php foreach ($v['list'] as $link):?>
    						<li><a target="_blank" href="<?php echo $link['linkUrl'];?>"><?php echo $link['linkName'];?></a></li>
    						<?php endforeach;?>
    					</ul>
				</div>	
				<?php endforeach;?>	
				</div>		
			</div>
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
