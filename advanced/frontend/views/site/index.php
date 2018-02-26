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
		        <a href="<?php echo $carousel['link'];?>" target="_blank"><img src="<?php echo $carousel['img'];?>" title="<?php echo $carousel['title'];?>" alt="<?php echo $carousel['title'];?>"></a>
		        <?php endforeach;?>
		    </div>
		</div>  
	</div>
	<div class="notice-box">
		<div class="notice-box-title"><h4 data-target-id="ggtz">公告通知</h4><a href="<?php echo Url::to(['news/list-by-catecode','code'=>'ggtz'])?>">更多&gt;</a></div>
		<ul class="articlelist" id="ggtz">
			<?php foreach ($data['ggtz'] as $ggtz):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$ggtz->id])?>" title="测试"><nobr><?php echo $ggtz->title;?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<div class="section-2">
	<div class="news-box">
		<div class="title">
    		<h4 class="news-selected" data-target-id="tzxw">统战新闻</h4>
    		<h4 class="news-unselected" data-target-id="syxw">社院新闻</h4>
    		<h4 class="news-unselected" data-target-id="szyw">时政要闻</h4>
    		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'tzxw'])?>">更多&gt;</a>
		</div>
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
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'xyjj'])?>" class="btn-img-itme1"></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'zzjg'])?>" class="btn-img-itme2"></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'kbcx'])?>" class="btn-img-itme3"></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wybm'])?>" class="btn-img-itme4"></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wkzx'])?>" class="btn-img-itme5"></a>
		<a href="<?php echo Yii::$app->params['xbjs.link'];?>" target= _blank  class="btn-img-itme6"></a>
	</div>
</div>
<img class="main-banner" src="/front/img/index/xiaoxun.jpg" />
<div class="section-3">
	<div class="news-box1">
		<div class="title">
			<h4 class="news-selected" data-target-id="whjl">文化交流</h4>
			<h4 class="news-unselected" data-target-id="dqxz">党群建设</h4>
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'whjl'])?>">更多&gt;</a>
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
			<h4 class="news-selected" data-target-id="jxxx">教学培训</h4>
			<h4 class="news-unselected" data-target-id="xyhd">学员园地</h4>
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'jxxx'])?>">更多&gt;</a>
		</div>
		<ul class="articlelist" id="jxxx">
			<?php foreach ($data['jxpx'] as $jxpx):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$jxpx->id]);?>" title="<?php echo $jxpx->title;?>"><nobr><?php echo $jxpx->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="xyhd">
			<?php foreach ($data['xyyd'] as $xyyd):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$xyyd->id]);?>" title="<?php echo $xyyd->title;?>"><nobr><?php echo $xyyd->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="news-box3">
		<div class="title">
			<h4 class="news-selected" data-target-id="kyxx">科研动态</h4>
			<h4 class="news-unselected" data-target-id="xxdt">智库中心</h4>
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'kyxx'])?>">更多&gt;</a>
		</div>
		<ul class="articlelist" id="kydt">
			<?php foreach ($data['kydt'] as $kydt):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$kydt->id])?>" title="<?php echo $kydt->title;?>"><nobr><?php echo $kydt->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
		<ul style="display: none" class="articlelist" id="xxdt">
			<?php foreach ($data['zkzx'] as $zkzx):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$zkzx->id])?>" title="<?php echo $zkzx->title;?>"><nobr><?php echo $zkzx->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<img class="main-banner" src="/front/img/index/hengfu.gif" />
<div class="section-4">
	<div class="news-box1">
		<div class="title">
			<h4 class="news-selected" data-target-id="szsy">市州社院</h4>
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'szsy'])?>">更多&gt;</a>
		</div>
		<ul class="articlelist" id="szsy">
			<?php foreach ($data['szsy'] as $szsy):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$szsy->id])?>" title="<?php echo $szsy->title;?>"><nobr><?php echo $szsy->title?></nobr></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="edu-box">
		<img src="/front/img/index/whjd_bg.jpg" width="100%" />
		<ul class="edu-list">
			<?php foreach ($data['jyjd'] as $jyjd):?>
			<li>
				<a href="<?php echo $jyjd->link;?>">
					<img  src="<?php echo $jyjd->baseImg?>"/>
					<p><?php echo $jyjd->baseName;?></p>
				</a>
			</li>
			<?php endforeach;?>
			<?php foreach ($data['jyjd'] as $jyjd):?>
			<li>
				<a href="<?php echo $jyjd->link;?>">
					<img  src="<?php echo $jyjd->baseImg?>"/>
					<p><?php echo $jyjd->baseName;?></p>
				</a>
			</li>
			<?php endforeach;?>
			
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
<div class="video-box">
    <div class="video-list-box">
    	<?php foreach ($data['sxsy'] as $sxsy):?>
    	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" id="video_item_<?php echo $sxsy->id;?>">
    		<a href="javascript:; <?php // echo Url::to(['video/start','id'=>$sxsy->id]);?>">
    			<img src="<?php echo $sxsy->videoImg;?>" />
    			<p><?php echo $sxsy->descr;?></p>
    			<span class="video-btn"></span>
    		</a>
    	</div>
    	<?php endforeach;?>
    	
    	<?php foreach ($data['sxsy'] as $sxsy):?>
    	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" id="video_item_<?php echo $sxsy->id;?>">
    		<a href="javascript:; <?php // echo Url::to(['video/start','id'=>$sxsy->id]);?>">
    			<img src="<?php echo $sxsy->videoImg;?>" />
    			<p><?php echo $sxsy->descr;?></p>
    			<span class="video-btn"></span>
    		</a>
    	</div>
    	<?php endforeach;?>
    	
    	<?php foreach ($data['sxsy'] as $sxsy):?>
    	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" id="video_item_<?php echo $sxsy->id;?>">
    		<a href="javascript:; <?php // echo Url::to(['video/start','id'=>$sxsy->id]);?>">
    			<img src="<?php echo $sxsy->videoImg;?>" />
    			<p><?php echo $sxsy->descr;?></p>
    			<span class="video-btn"></span>
    		</a>
    	</div>
    	<?php endforeach;?>
    </div>
</div>


<?php 
$js = <<<JS
$(document).on('click','.title h4',function(){
    var _this = $(this);
    var cateCode = _this.data("target-id");
    _this.parent().parent().find('.articlelist').hide();
    $("#"+cateCode).show();

    _this.parent().find('h4').removeClass('news-selected').removeClass('news-unselected').addClass('news-unselected');
    _this.removeClass('news-unselected').addClass('news-selected');
    
    var url = _this.parent().find("a").attr("href");
    var newUrl = common.changeUrlArg(url,'code',cateCode);
    _this.parent().find("a").attr("href",newUrl)
});

$(document).on('click','.video-item',function(){
	if($(this).hasClass('prism-player')){
		return false;
	}
	var source = $(this).data('videourl');
	var id = $(this).attr('id');
	var player = new Aliplayer({
            id: id,
            width: '280px',
			height: '185px',
            autoplay: true,
            //支持播放地址播放,此播放优先级最高
            source : source,
            /* //播放方式二：点播用户推荐
            vid : '1e067a2831b641db90d570b6480fbc40',
            playauth : '',
            cover: 'http://liveroom-img.oss-cn-qingdao.aliyuncs.com/logo.png',            
            //播放方式三：仅MTS用户使用
            vid : '1e067a2831b641db90d570b6480fbc40',
            accId: '',
            accSecret: '',
            stsToken: '',
            domainRegion: '',
            authInfo: '',
            //播放方式四：使用STS方式播放
            vid : '1e067a2831b641db90d570b6480fbc40',
            accessKeyId: '',
            securityToken: '',
            accessKeySecret: '' */
            },function(player){
                console.log('播放器创建好了。')
           });
	player.on('ready',function(){
		$(".prism-big-play-btn").remove();
	});
})

JS;

$css = <<<CSS
/*教育基地*/
.section-4 .edu-box {
    position: relative;
    overflow: hidden;
    width:776px;
}
.edu-list {
    position: absolute;
    top: 117;
    margin: 0;
    padding: 0;
    left: 0;
    -webkit-animation: 20s move infinite linear;
    width: 1565px;
    height:172px;
}
.edu-list li {
    width: 250px;
    height: 148px;
    float: left;
    margin-right: 13px;
    margin-bottom: 25px;
}
@-webkit-keyframes move{  
    0% {  
          left: 0;  
    }  
    100% {  
          left: -776px;  
    }  
}  
@keyframes move {  
    0% {  
       left: 0;  
    }  
    100% {  
       left: -776px;  
    }  
}  
.edu-box:hover .edu-list {  
    -webkit-animation-play-state: paused; /*动画暂停播放*/  
}  
/*视频*/
.video-box{
    margin-top: 25px;
    overflow: hidden;
    position: relative;
    height: 185px;
}
.video-list-box {
    position: absolute;
    top: 0;
    margin: 0;
    padding: 0;
    left: 0;
    -webkit-animation: 20s move infinite linear;
    width: 2250px;
}

@-webkit-keyframes move{  
    0% {  
          left: 0;  
    }  
    100% {  
          left: -1170px;  
    }  
}  
@keyframes move {  
    0% {  
       left: 0;  
    }  
    100% {  
       left: -1170px;  
    }  
}  
.video-box:hover .video-list-box {  
    -webkit-animation-play-state: paused; /*动画暂停播放*/  
}  
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>
		