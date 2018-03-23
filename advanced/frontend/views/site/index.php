<?php 

use yii\helpers\Url;
use frontend\assets\AppAsset;
$params = $this->params;
$this->title = "首页_".$params['webCfgs']['siteName'];


?>

<div class="news-box1">
	<div class="left tzxw">
		<div class="left theme-box"></div>
		<div class="left news">
			<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['tzxw']['id']]);?>" title="<?php echo $data['tzxw']['title'];?>"><?php echo $data['tzxw']['title'];?></a></h4>
			<hr />
			<p>
				<?php echo $data['tzxw']['summary'];?>
			</p>
		</div>
	</div>
	<div class="right szyw">
		<div class="left theme-box"></div>
		<div class="left news">
			<ul>
    			<?php foreach ($data['szyw'] as $szyw):?>
    			<li><a href="<?php echo Url::to(['news/detail','id'=>$szyw->id])?>" title="<?php echo $szyw->title;?>"><?php echo $szyw->title?></a></li>
    			<?php endforeach;?>
			</ul>
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
			<h4 class="text-over"><?php echo $recommen['title'];?></h4>
			<p>
				<?php echo $recommen['summary'];?>
			</p>
		</div>
	<?php endforeach;?>
	</div>
</div>

<img class="main-banner" src="/front/img/index/xiaoxun.jpg" />

<div class="news-box3">
	<div class="left news-list-box">
		<div class="left news-cates">
			<div class="cate selected" data-target-id="syxw">社院新闻</div>
			<div class="cate" data-target-id="jxpx">教学培训</div>
			<div class="cate" data-target-id="kydt">科研动态</div>
			<div class="cate" data-target-id="dqxz">党群建设</div>
			<div class="cate" data-target-id="whjl">文化学院</div>
			<div class="cate" data-target-id="xyyd">学员天地</div>
			<div class="cate" data-target-id="szsy">市州社院</div>
			<div class="cate" data-target-id="zkzx">智库中心</div>
		</div>
		<!-- 社院新闻 -->
		<div class="left news-list" style="display:block" id="syxw">
			<div class="news-hot">
				<?php if(!empty($data['syxw'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['syxw'][0]['id']]);?>" title="<?php echo $data['syxw'][0]['title'];?>"><?php echo $data['syxw'][0]['title'];?></a></h4>
				<p><?php echo $data['syxw'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['syxw'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['syxw'] as $k=>$syxw):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$syxw->id])?>" title="<?php echo $syxw->title;?>"><?php echo $syxw->title;?></a></li>
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
				<p><?php echo $data['jxpx'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['jxpx'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['jxpx'] as $k=>$jxpx):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$jxpx->id])?>" title="<?php echo $jxpx->title;?>"><?php echo $jxpx->title;?></a></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'jxxx']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 科研动态 -->
		<div class="left news-list" id="kydt">
			<div class="news-hot">
				<?php if(!empty($data['kydt'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['kydt'][0]['id']]);?>" title="<?php echo $data['kydt'][0]['title'];?>"><?php echo $data['kydt'][0]['title'];?></a></h4>
				<p><?php echo $data['kydt'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['kydt'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['kydt'] as $k=>$kydt):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$kydt->id])?>" title="<?php echo $kydt->title;?>"><?php echo $kydt->title;?></a></li>
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
				<p><?php echo $data['dqxz'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['dqxz'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['dqxz'] as $k=>$dqxz):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$dqxz->id])?>" title="<?php echo $dqxz->title;?>"><?php echo $dqxz->title;?></a></li>
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
				<p><?php echo $data['whjl'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['whjl'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['whjl'] as $k=>$whjl):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$whjl->id])?>" title="<?php echo $whjl->title;?>"><?php echo $whjl->title;?></a></li>
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
				<p><?php echo $data['xyyd'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['xyyd'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['xyyd'] as $k=>$xyyd):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$xyyd->id])?>" title="<?php echo $xyyd->title;?>"><?php echo $xyyd->title;?></a></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xyhd']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 市州社院 -->
		<div class="left news-list" id="szsy">
			<div class="news-hot">
				<?php if(!empty($data['szsy'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['szsy'][0]['id']]);?>" title="<?php echo $data['szsy'][0]['title'];?>"><?php echo $data['szsy'][0]['title'];?></a></h4>
				<p><?php echo $data['szsy'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['szsy'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['szsy'] as $k=>$szsy):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$szsy->id])?>" title="<?php echo $szsy->title;?>"><?php echo $szsy->title;?></a></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'szsy']);?>">&gt;&gt;更多</a>
		</div>
		<!-- 智库中心 -->
		<div class="left news-list" id="zkzx">
			<div class="news-hot">
				<?php if(!empty($data['zkzx'])):?>
				<h4 class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$data['zkzx'][0]['id']]);?>" title="<?php echo $data['zkzx'][0]['title'];?>"><?php echo $data['zkzx'][0]['title'];?></a></h4>
				<p><?php echo $data['zkzx'][0]['summary'];?><a class="articledetail" href="<?php echo Url::to(['news/detail','id'=>$data['zkzx'][0]['id']]);?>">(详情)</a></p>
				<?php endif;?>
			</div>
			<ul>
				<?php foreach ($data['zkzx'] as $k=>$zkzx):?>
    				<?php if($k>0):?>
        			<li class="text-over"><a href="<?php echo Url::to(['news/detail','id'=>$zkzx->id])?>" title="<?php echo $zkzx->title;?>"><?php echo $zkzx->title;?></a></li>
        			<?php endif;?>
    			<?php endforeach;?>
			</ul>
			<a class="news-more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'xxdt']);?>">&gt;&gt;更多</a>
		</div>
	</div>
	
	<div class="right ggtz-box">
		<ul>
			<?php foreach ($data['ggtz'] as $ggtz):?>
			<li><a href="<?php echo Url::to(['news/detail','id'=>$ggtz->id])?>" title="<?php echo $ggtz->title;?>"><?php echo $ggtz->title;?></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<img class="main-banner" src="/front/img/index/hengfu.gif" />
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
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'kbcx'])?>"><img alt="课表查询" src="/front/img/index/kbcx_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wybm'])?>"><img alt="在线报名" src="/front/img/index/zxbm_img_btn.png" /></a>
		<a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wkzx'])?>"><img alt="微课中心" src="/front/img/index/wkzx_img_btn.png" /></a>
		<a href="<?php echo Yii::$app->params['xbjs.link'];?>" target= _blank ><img alt="学报检索" src="/front/img/index/xbjs_img_btn.png" /></a>
	</div>
</div>

<div class="news-box5">
	<div class="video-banner"><a href="<?php echo Url::to(['news/list-by-catecode','code'=>'sxsy'])?>" title="">更多&gt;</a></div>
	<div id="video-box" class="video-box">
    	<div id="video-list-box" class="video-list-box">
        	<?php foreach ($data['sxsy'] as $sxsy):?>
        	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" id="video_item_<?php echo $sxsy->id;?>">
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
        	<div class="video-item" data-videourl="<?php echo $sxsy->video;?>" id="video_item_<?php echo $sxsy->id;?>_cp">
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
		