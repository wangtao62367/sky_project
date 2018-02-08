<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\publics\MyHelper;
use common\models\CategoryType;

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
			<ul>
			<?php foreach ($list['data'] as $val):?>
				<?php if ($currentCate->type == CategoryType::ARTICLE):?>
					<li class="article-item"><a href="<?php echo Url::to(['news/detail','id'=>$val['id']])?>" title="<?php echo $val['title'];?>"><?php echo MyHelper::timestampToDate($val['publishTime']);?>  <?php echo $val['title'];?></a></li>
				<?php elseif ($currentCate->type == CategoryType::VIDEO):?>
					<li  class="video-item">
    					<a href="<?php echo Url::to(['video/start','id'=>$val['id']]);?>">
                			<img src="<?php echo $val['videoImg'];?>" />
                			<p><?php echo $val['descr'];?></p>
                			<span class="video-btn"></span>
    					</a>
					</li>
				<?php elseif ($currentCate->type == CategoryType::IMAGE):?>
					<li  class="image-item">
    					<a href="<?php echo !empty($val['link']) ? $val['link'] : 'javascript:;';?>">
                			<img src="<?php echo $val['photo'];?>" />
                			<p><?php echo $val['title'];?></p>
    					</a>
					</li>
				<?php elseif ($currentCate->type == CategoryType::FILE):?>
					<li class="file-item">
						<a href="<?php echo $val['uri'];?>" title="<?php echo $val['descr'];?>"><?php echo MyHelper::timestampToDate($val['modifyTime']);?>  <?php echo $val['descr'];?></a>
					</li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
			
		</div>
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
?>