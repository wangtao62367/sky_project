<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\publics\MyHelper;

?>

<img src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0])?>" class="news"><?php echo $parent->codeDesc;?></a></li>
		<?php foreach ($cateList as $cate):?>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$cate->id])?>" <?php if($cate->id == $cateid){ $curentCate = $cate->text; echo 'class="UnitedFront"';};?>><?php echo $cate->text;?></a></li>
		<?php endforeach;?>
	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $curentCate;?></h2>
		<p>您的位置：<a href="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0])?>"><?php echo $parent->codeDesc;?></a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$cateid])?>"><?php echo $curentCate;?></a></p>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<div class="newsList">
			<ul>
			<?php foreach ($articleList as $article):?>
				<li><a href="<?php echo Url::to(['news/detail','id'=>$article->id])?>" title="<?php echo $article->title;?>"><?php echo MyHelper::timestampToDate($article->publishTime);?>  <?php echo $article->title;?></a></li>
			<?php endforeach;?>
			</ul>
		</div>
		<div class="page">
			<ul>
				<li><a class="firstPage">1</a></li>
				<li><a>2</a></li>
				<li><a>3</a></li>
				<li><a>4</a></li>
				<li><a>...</a></li>
				<li><a>41</a></li>
				<li><a>下一页</a></li>
				<li><a>末页</a></li>
			</ul>
	    </div>
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 

AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
?>