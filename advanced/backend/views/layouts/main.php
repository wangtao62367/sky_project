<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
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
	<img  src="/admin/img/logo.png"/>
	<span>四川省社会主义后台管理系统</span>
	<span class="login-out">
		欢迎您，<?php echo Yii::$app->user->identity->account ;?>
		<?php echo Html::a('退出',Url::to(['public/logout']),['title'=>'退出']);?>
	</span>
</div>
<div class="left">
	<ul class="nav">
		<?php $controller = Yii::$app->controller->id;?>
		<?php foreach (Yii::$app->params['menu'] as $menu):?>
		<?php $isopened = in_array($controller, array_column($menu['submenu'],'module')) ? true: false;?>
		<li class="nav-memu">
			<a class="nav-memu-title <?php echo $isopened ? 'is-opened' : '';?>" href="<?php echo $menu['url']!='#'? Url::to([$menu['url']]) : '#';?>">
				<?php echo $menu['label'];?>
				<?php if(!empty($menu['submenu'])):?>
					<?php if($isopened):?>
						<i class="ico_up"></i>
					<?php else :?>
						<i class="ico_down"></i>
					<?php endif;?>
				<?php endif;?>
			</a>
			<?php if((bool)count($menu['submenu'])):?>
			<ul <?php echo $isopened ? '' : 'style="display: none;"' ;?> >
				<?php foreach ($menu['submenu'] as $submenu):?>
					<?php $active = $controller == $submenu['module'] ? 'active' : '';?>
					<li><a class="nav-memu-item <?php echo $active;?>" href="<?php echo Url::to([$submenu['url']])?>""><?php echo $submenu['label'];?> </a></li>
				<?php endforeach;?>
			</ul>
			<?php endif;?>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<div class="content">
	<?php echo $content; ?>
</div>
<?php ;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
