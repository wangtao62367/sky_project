<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="header">
			<div class="container">
				<div class="full-text-search">
					<span class="search-form-sp"><input type="text" name="keywords" /></span>
					<span class="search-btn-sp"><button>搜索</button></span>
					<a href="#">登录</a> | <a href="#">注册</a>
				</div>
				<div class="header-crousel">
					<div class="logo">
						<img src="<?php echo $params['webCfgs']['logo'] ? $params['webCfgs']['logo']: '/front/img/index/logo.png';?>" width="140px" />
						<div class="logo-title">
							<h3><?php echo $params['webCfgs']['siteName'];?></h3>
							<h3>四川省中华文化学院</h3>
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
						<li><a class="active"  href="#">学院首页</a></li>
						<?php foreach ($params['nav'] as $v):?>
						<li><a href="#"><?php echo $v['codeDesc'];?>
							</a>
							<ul class="nav-item" >
								<?php foreach ($v['cates'] as $cate):?>
								<li><a href="#"><?php echo $cate['text'];?></a></li>
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
