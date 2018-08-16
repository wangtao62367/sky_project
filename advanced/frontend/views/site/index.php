<?php 

use yii\helpers\Url;
use frontend\assets\AppAsset;
$params = $this->params;
$this->title = "首页_".$params['webCfgs']['siteName'];


?>

<div class="news-box1">
	<div class="left szyw">
		<div class="left theme-box">
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'szyw']);?>" title="更多时政新闻"><img alt="" src="/front/img/index/szyw_bg.png"></a>
		</div>
		<div class="left news">
			<ul>
    			<?php foreach ($data['szyw'] as $szyw):?>
    			<li><a href="<?php echo Url::to(['news/detail','id'=>$szyw->id])?>" title="<?php echo $szyw->title;?>"><?php echo mb_substr($szyw->title,0,29,'utf-8');?></a><?php if($szyw['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
    			<?php endforeach;?>
			</ul>
		</div>
	</div>
	<div class="right tzxw">
		<div class="left theme-box">
			<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'tzxw']);?>" title="更多统战新闻"><img alt="" src="/front/img/index/tzxw_bg.png"></a>
		</div>
		<div class="left news">
			<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['tzxw']['id']]);?>" title="<?php echo $data['tzxw']['title'];?>"><?php echo $data['tzxw']['title'];?></a></h4>
			<hr />
			<p>
				<?php echo $data['tzxw']['summary'];?>
			</p>
		</div>
	</div>
</div>

<div class="news-box2">
	<div class="left news-img-box">
		<?php if(!empty($data['recommen'])):?>
		<a href="<?php echo Url::to(['news/detail','id'=> $data['recommen'][0]['id']])?>" title="<?php echo $data['recommen'][0]['title'];?>" ><img alt="<?php echo $data['recommen'][0]['title'];?>" src="<?php echo $data['recommen'][0]['titleImg'];?>" /></a>
		<?php endif;?>
	</div>
	<div class="left news-items">
	<?php foreach ($data['recommen'] as $k=>$recommen):?>
		
		<div class="item <?php echo $k==0 ? 'selected' : '';?>" data-target-titleimg="<?php echo $recommen['titleImg'];?>" data-target-url="<?php echo Url::to(['news/detail','id'=> $recommen['id']])?>" data-target-title="<?php echo $recommen['title'];?>">
			<img alt="" src="<?php echo $recommen['titleImg'];?>" style="display: none;">
			<a href="<?php echo Url::to(['news/detail','id'=> $recommen['id']])?>" title="<?php echo $recommen['title'];?>" >
			<h4 class="text-over"><?php echo $recommen['title'];?></h4>
			<p>
				<?php echo $recommen['summary'];?>
			</p>
			</a>
		</div>
					
	<?php endforeach;?>
	</div>
</div>

<?php if(empty($params['webCfgs']['indexMainBanner1'])):?>
	<img class="main-banner" src="/front/img/index/xiaoxun.jpg" />
<?php else:?>
<a href="<?php echo empty($params['webCfgs']['indexMainBanner1Link']) ? 'javascript:;' : $params['webCfgs']['indexMainBanner1Link'];?>"><img class="main-banner indexMainBanner1" src="<?php echo $params['webCfgs']['indexMainBanner1'];?>" /></a>
<?php endif;?>

<?php if(empty($params['webCfgs']['indexMainBanner2'])):?>
	<img class="main-banner" src="/front/img/index/hengfu.gif" />
<?php else:?>
<a href="<?php echo empty($params['webCfgs']['indexMainBanner2Link']) ? 'javascript:;' : $params['webCfgs']['indexMainBanner2Link'];?>"><img class="main-banner indexMainBanner2" src="<?php echo $params['webCfgs']['indexMainBanner2'];?>" /></a>
<?php endif;?>



<div class="news-box3">
	<div class="left news-list-box">
		<div class="left news-cates">
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'syxw']);?>">
			<div class="cate selected" data-target-id="syxw">社院新闻</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'jxxx']);?>">
			<div class="cate" data-target-id="jxpx">教学培训</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'mmst']);?>">
			<div class="cate" data-target-id="mmst">名&nbsp;&nbsp;师&nbsp;&nbsp;堂</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'whjl']);?>">
			<div class="cate" data-target-id="whjl">文化交流</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'kyxx']);?>">
			<div class="cate" data-target-id="kydt">科研动态</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'dqxz']);?>">
			<div class="cate" data-target-id="dqxz">党群行政</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xyhd']);?>">
			<div class="cate" data-target-id="xyyd">学员天地</div>
			</a>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xxdt']);?>">
			<div class="cate" data-target-id="zkzx">智库中心</div>
			</a>
		</div>
		<!-- 社院新闻 -->
		<div class="left news-list" style="display:block" id="syxw">
			<div class="news-hot">
				<?php if(!empty($data['syxw'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['syxw'][0]['id']]);?>" title="<?php echo $data['syxw'][0]['title'];?>"><?php echo $data['syxw'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['syxw'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['syxw'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['syxw'] as $k=>$syxw):?>
    				<?php if($k>0):?>
    				<li class="text-over"><a <?php if($syxw['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$syxw->id])?>" title="<?php echo $syxw->title;?>"><?php echo mb_substr($syxw->title, 0,33,'utf-8');?></a><?php if($syxw['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'syxw']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 教学培训 -->
		<div class="left news-list" id="jxpx">
			<div class="news-hot">
				<?php if(!empty($data['jxpx'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['jxpx'][0]['id']]);?>" title="<?php echo $data['jxpx'][0]['title'];?>"><?php echo $data['jxpx'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['jxpx'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['jxpx'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['jxpx'] as $k=>$jxpx):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($jxpx['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$jxpx->id])?>" title="<?php echo $jxpx->title;?>"><?php echo mb_substr($jxpx->title,0,33,'utf-8');?></a><?php if($jxpx['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'jxxx']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 名师堂 -->
		<div class="left news-list" id="mmst">
			
			<?php foreach ($data['mmst'] as $k=>$val):?>
			
			<div class="mmst-item" >
				<a  href="javascript:;" class="dialog" data-tagget-url="<?php echo Url::to(['famous-teacher/showinfo','id'=>$val['id']])?>">
				<div class="mmst-img-box" style="">
					<img alt="" src="<?php echo $val['avater'];?>" width="75px" height="115px">
				</div>
				<div class="mmst-desc" style="">
					<p class="mmst-name" style="margin-top: 24px;margin-bottom: 10px;font-size: 20px;color: #191919;font-weight: 600;"><?php echo $val['name'];?></p>
					<p class="mmst-job" style="font-weight:600;font-size:16px"> <?php echo $val['teach'];?></p>
				</div>
				</a>
			</div>
			
			<?php endforeach;?>
			
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'mmst']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 科研动态 -->
		<div class="left news-list" id="kydt">
			<div class="news-hot">
				<?php if(!empty($data['kydt'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['kydt'][0]['id']]);?>" title="<?php echo $data['kydt'][0]['title'];?>"><?php echo $data['kydt'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['kydt'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['kydt'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['kydt'] as $k=>$kydt):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($kydt['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$kydt->id])?>" title="<?php echo $kydt->title;?>"><?php echo mb_substr($kydt->title,0,33,'utf-8');?></a><?php if($kydt['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'kyxx']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 党群建设 -->
		<div class="left news-list" id="dqxz">
			<div class="news-hot">
				<?php if(!empty($data['dqxz'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['dqxz'][0]['id']]);?>" title="<?php echo $data['dqxz'][0]['title'];?>"><?php echo $data['dqxz'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['dqxz'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['dqxz'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['dqxz'] as $k=>$dqxz):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($dqxz['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$dqxz->id])?>" title="<?php echo $dqxz->title;?>"><?php echo mb_substr($dqxz->title,0,33,'utf-8');?></a><?php if($dqxz['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'dqxz']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 文化学院 -->
		<div class="left news-list" id="whjl">
			<div class="news-hot">
				<?php if(!empty($data['whjl'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['whjl'][0]['id']]);?>" title="<?php echo $data['whjl'][0]['title'];?>"><?php echo $data['whjl'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['whjl'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['whjl'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['whjl'] as $k=>$whjl):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($whjl['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$whjl->id])?>" title="<?php echo $whjl->title;?>"><?php echo mb_substr($whjl->title,0,33,'utf-8');?></a><?php if($whjl['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
    			
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'whjl']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 学员天地 -->
		<div class="left news-list" id="xyyd">
			<div class="news-hot">
				<?php if(!empty($data['xyyd'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['xyyd'][0]['id']]);?>" title="<?php echo $data['xyyd'][0]['title'];?>"><?php echo $data['xyyd'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['xyyd'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['xyyd'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['xyyd'] as $k=>$xyyd):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($xyyd['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$xyyd->id])?>" title="<?php echo $xyyd->title;?>"><?php echo mb_substr($xyyd->title,0,33,'utf-8');?></a><?php if($xyyd['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xyhd']);?>">&gt;&gt;更多</a>
		</div>

		<!-- 智库中心 -->
		<div class="left news-list" id="zkzx">
			<div class="news-hot">
				<?php if(!empty($data['zkzx'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['zkzx'][0]['id']]);?>" title="<?php echo $data['zkzx'][0]['title'];?>"><?php echo $data['zkzx'][0]['title'];?></a></h4>
				<p><?php echo mb_substr($data['zkzx'][0]['summary'],0,106,'utf-8');?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['zkzx'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['zkzx'] as $k=>$zkzx):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a <?php if($zkzx['publishTime'] > (time() - 5*24*3600)):?> class="hotnews" <?php endif;?> href="<?php echo Url::to(['news/detail','id'=>$zkzx->id])?>" title="<?php echo $zkzx->title;?>"><?php echo mb_substr($zkzx->title,0,33,'utf-8');?></a><?php if($zkzx['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xxdt']);?>">&gt;&gt;更多</a>
		</div>
	</div>
	
	<div class="right ggtz-box">
		<ul>
			<?php foreach ($data['ggtz'] as $ggtz):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$ggtz->id])?>" title="<?php echo $ggtz->title;?>"><?php echo mb_substr($ggtz->title,0,16,'utf-8');?></a><?php if($ggtz->publishTime > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>

<div class="new-box6">
	<div class="box-tzgs">
		<img class="" src="/front/img/index/tzgs_bg.png" />
		<a class="more tzgs-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'tzgs'])?>" title="查看更多统一战线故事"></a>
		<div class="tzgs-news-box">
			<?php foreach ($data['tzgs'] as $val):?>
			<div class="news-items">
				<a href="<?php echo Url::to(['news/detail','id'=>$val->id])?>" title="<?php echo $val->title ;?>">
					<img alt="" src="<?php echo $val->titleImg;?>" height="170px" width="255px">
					<p><?php echo $val->title;?></p>
				</a>
				
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<div class="box-wxsh">
		<img src="/front/img/index/wxsh_bg.png" />
		<a class="more wxsh-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'wxsh'])?>" title="查看更多优秀文学书画"></a>
		<div class="wxsh-news-box">
			<?php foreach ($data['wxsh'] as $val):?>
			<div class="news-items">
				<a href="<?php echo Url::to(['news/detail','id'=>$val->id])?>" title="<?php echo $val->title ;?>">
					<img alt="" src="<?php echo $val->titleImg;?>" height="170px" width="255px">
					<p><?php echo $val->title;?></p>
				</a>
				
			</div>
			<?php endforeach;?>
			
		</div>
	</div>

</div>


<div class="news-box4">
	<div class="left edu-box">
		<img src="/front/img/index/whjd_img.jpg" width="100%" />
		<div id="scroll_div">
			<ul id="edu-list" class="edu-list">
				<?php foreach ($data['jyjd'] as $jyjd):?>
				<li>
					<a href="<?php echo $jyjd['link'];?>">
						<img  src="<?php echo $jyjd['baseImg'];?>"/>
						<p><?php echo $jyjd['baseName'];?></p>
					</a>
				</li>
				<?php endforeach;?>
			</ul>
			<ul id="edu-list-end" class="edu-list">
				<?php foreach ($data['jyjd'] as $jyjd):?>
				<li>
					<a href="<?php echo $jyjd['link'];?>">
						<img  src="<?php echo $jyjd['baseImg'];?>"/>
						<p><?php echo $jyjd['baseName'];?></p>
					</a>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
	<div class="right quickbtn-box">
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'zzjg'])?>"><img alt="机构设置" src="/front/img/index/zzjg_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'mmst'])?>"><img alt="名师堂" src="/front/img/index/mst_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'kbcx'])?>"><img alt="课表查询" src="/front/img/index/kbcx_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'qyxw'])?>"><img alt="理论前沿" src="/front/img/index/llqy_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wybm'])?>"><img alt="在线报名" src="/front/img/index/zxbm_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'szsy'])?>"><img alt="市州社院" src="/front/img/index/szsy_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wkzx'])?>"><img alt="微课中心" src="/front/img/index/wkzx_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'xxhjs'])?>"><img alt="微课中心" src="/front/img/index/xxhjs_img_btn.png" /></a>
		<a href="<?php echo Yii::$app->params['xbjs.link'];?>" target= _blank ><img alt="学报检索" src="/front/img/index/xbjs_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'zlxz'])?>"><img alt="微课中心" src="/front/img/index/zlxz_img_btn.png" /></a>
	</div>
</div>

<div class="news-box5">
	<div class="video-banner"><a href="<?php echo Url::to(['news/list-by-catecode','code'=>'sxsy'])?>" title="">更多&gt;</a></div>
	<div id="video-box" class="video-box">
    	<div id="video-list-box" class="video-list-box">
        	<?php foreach ($data['sxsy'] as $sxsy):?>
        	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" data-videotype="<?php echo $sxsy->videoType;?>" id="video_item_<?php echo $sxsy->id;?>">
        		<a href="javascript:;">
        			<img src="<?php echo $sxsy['videoImg'];?>" />
        			<p><?php echo $sxsy['descr'];?></p>
        			<span class="video-btn"></span>
        		</a>
        	</div>
        	<?php endforeach;?>
        </div>
        <div class="video-list-box" id="video-list-box-end">
        	<?php foreach ($data['sxsy'] as $sxsy):?>
        	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" data-videotype="<?php echo $sxsy->videoType;?>" id="video_item_<?php echo $sxsy->id;?>_cp">
        		<a href="javascript:;">
        			<img src="<?php echo $sxsy['videoImg'];?>" />
        			<p><?php echo $sxsy['descr'];?></p>
        			<span class="video-btn"></span>
        		</a>
        	</div>
        	<?php endforeach;?>
        </div>
	</div>
</div>
<?php 
AppAsset::addScript($this, '/front/js/index.js');
AppAsset::addCss($this, '/front/css/index.css');
$getAdv = Url::to(['site/adv']);
$js = <<<JS
showAdv();
function showAdv(){
    var delay = 1500;
    setTimeout(function(){
        $.get('$getAdv',function(res){
            var len = res.length;
            if(len > 0){
                for(var i =0;i<len;i++){
                    if(res[i].status == 1){
                    createAdvDom(res[i].position,res[i].advs,res[i].imgs,res[i].link);
                    }
                }
            }
        })
    },delay)
}
JS;
$css = <<<CSS
#tzxw nobr,#syxw nobr,#szyw nobr{
    display: inline-block;
    text-indent: 0px;
    width: 590px;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
}
#tzxw span,#syxw span,#szyw span{display:inline-block;float:right;}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>
		