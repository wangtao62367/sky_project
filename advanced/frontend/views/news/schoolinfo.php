<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;

?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0])?>" class="news"><?php echo $parent->codeDesc;?></a></li>
		<?php foreach ($cateList as $cate):?>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$cate->id])?>" <?php if($cate->id == $currentCate->id){ echo 'class="UnitedFront"';};?>><?php echo $cate->text;?></a></li>
		<?php endforeach;?>
	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $currentCate->text;?></h2>
		<p class="crumbs">您的位置：<a href="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0])?>"><?php echo $parent->codeDesc;?></a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$currentCate->id])?>"><?php echo $currentCate->text;?></a></p>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<div class="newsList">
			<?php echo $info->text;?>
		</div>
	    <div class="page">
            <!-- 这里显示分页 -->
            <div id="Pagination"></div>
        </div>
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
$js = <<<JS

JS;
$this->registerJs($js);
?>