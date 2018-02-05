<?php 

use yii\helpers\Url;

$this->title="首页"
?>
<div class="section-1">
	<div class="crousle-box">
		<div id="banner">  
		    <div id="banner_bg"></div>
		<!--标题背景-->
		    <div id="banner_info"></div>
		<!--标题-->
		    <ul> 
		    	<?php $count = count($data['carousel']); for ($i = 1 ; $i<=$count ; $i++):?>  
		        <li <?php echo $i==1?'class="on"':''; ?> data-num = "<?php echo $i;?>"></li>
		        <?php endfor;?>
		    </ul>
		    <div id="banner_list">
		    	<?php foreach ($data['carousel'] as $carousel):?>
		        <a href="<?php echo Url::to(['news/detail','id'=>$carousel->id])?>" target="_blank"><img src="<?php echo $carousel->titleImg;?>" title="<?php echo $carousel->title;?>" alt="<?php echo $carousel->title;?>"></a>
		        <?php endforeach;?>
		    </div>
		</div>  
	</div>
	<div class="notice-box">
		<div class="title"><h4>公告通知</h4><a href="#">更多&gt;</a></div>
		<ul class="articlelist">
			<?php foreach ($data['ggtz'] as $ggtz):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$ggtz->id])?>" title="测试"><nobr><?php echo $ggtz->title;?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<div class="section-2">
	<div class="news-box">
		<div class="title"><h4 class="news-selected">统战新闻</h4><h4 class="news-unselected">社院新闻</h4><h4 class="news-unselected">时政要闻</h4><a href="#">更多&gt;</a></div>
		<ul class="articlelist" id="tzxw">
			<?php foreach ($data['tzxw'] as $tzxw):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$tzxw->id])?>" title="<?php echo $tzxw->title;?>"><nobr><?php echo $tzxw->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="syxw">
			<?php foreach ($data['syxw'] as $syxw):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$syxw->id])?>" title="<?php echo $syxw->title;?>"><nobr><?php echo $syxw->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="szyw">
			<?php foreach ($data['szyw'] as $szyw):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$szyw->id])?>" title="<?php echo $szyw->title;?>"><nobr><?php echo $szyw->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="btn-box">
		<a href="#" class="btn-img-itme1"></a>
		<a href="#" class="btn-img-itme2"></a>
		<a href="#" class="btn-img-itme3"></a>
		<a href="#" class="btn-img-itme4"></a>
		<a href="#" class="btn-img-itme5"></a>
		<a href="#" class="btn-img-itme6"></a>
	</div>
</div>
<img class="main-banner" src="/front/img/index/校训.jpg" />
<div class="section-3">
	<div class="news-box1">
		<div class="title">
			<h4 class="news-selected">文化交流</h4>
			<h4 class="news-unselected">党群建设</h4>
			<a href="#">更多&gt;</a>
		</div>
		<ul class="articlelist" id="whjl">
			<?php foreach ($data['tzxw'] as $whjl):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$whjl->id]);?>" title="<?php echo $whjl->title;?>"><nobr><?php echo $whjl->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="dqxz">
			<?php foreach ($data['dqxz'] as $dqxz):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$dqxz->id]);?>" title="<?php echo $dqxz->title;?>"><nobr><?php echo $dqxz->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="news-box2">
		<div class="title">
			<h4 class="news-selected">教学培训</h4>
			<h4 class="news-unselected">学员园地</h4>
			<a href="#">更多&gt;</a>
		</div>
		<ul class="articlelist" id="jxpx">
			<?php foreach ($data['jxpx'] as $jxpx):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$jxpx->id]);?>" title="<?php echo $jxpx->title;?>"><nobr><?php echo $jxpx->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="xyyd">
			<?php foreach ($data['xyyd'] as $xyyd):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$xyyd->id]);?>" title="<?php echo $xyyd->title;?>"><nobr><?php echo $xyyd->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="news-box3">
		<div class="title">
			<h4 class="news-selected">科研动态</h4>
			<h4 class="news-unselected">智库中心</h4>
			<a href="#">更多&gt;</a>
		</div>
		<ul class="articlelist" id="kydt">
			<?php foreach ($data['kydt'] as $kydt):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$kydt->id])?>" title="<?php echo $kydt->title;?>"><nobr><?php echo $kydt->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="zkzx">
			<?php foreach ($data['zkzx'] as $zkzx):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$zkzx->id])?>" title="<?php echo $zkzx->title;?>"><nobr><?php echo $zkzx->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<img class="main-banner" src="/front/img/index/横幅.gif" />
<div class="section-4">
	<div class="news-box1">
		<div class="title">
			<h4 class="news-selected">市州社院</h4>
			<a href="#">更多&gt;</a>
		</div>
		<ul class="articlelist" id="szsy">
			<?php foreach ($data['szsy'] as $szsy):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$szsy->id])?>" title="<?php echo $szsy->title;?>"><nobr><?php echo $szsy->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="edu-box">
		<img src="/front/img/index/文化基地.jpg" width="100%" />
		<ul class="edu-list">
			<?php foreach ($data['jyjd'] as $jyjd):?>
			<li>
				<a href="<?php echo $jyjd->link;?>">
					<img  src="<?php echo $jyjd->baseImg?>"/>
					<p><?php echo $jyjd->baseName;?></p>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>

</div>
<div class="video-banner"><a href="#">更多&gt;</a></div>
<div class="video-list-box">
	<?php foreach ($data['sxsy'] as $sxsy):?>
	<div class="video-item">
		<a href="<?php echo Url::to(['video/start','id'=>$sxsy->id]);?>">
			<img src="<?php echo $sxsy->videoImg;?>" />
			<p><?php echo $sxsy->descr;?></p>
			<span class="video-btn"></span>
		</a>
	</div>
	<?php endforeach;?>
</div>
		