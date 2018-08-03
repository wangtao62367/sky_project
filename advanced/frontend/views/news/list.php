<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\publics\MyHelper;
use common\models\CategoryType;
use common\models\TestPaper;

$this->title = $parent->codeDesc . '-'.$currentCate->text;
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0,'pcode'=>$parent->code])?>" class="news"><?php echo $parent->codeDesc;?></a></li>
		<?php foreach ($cateList as $cate):?>
		<li><a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$cate->id,'pcode'=>$parent->code])?>" <?php if($cate->id == $currentCate->id){ echo 'class="UnitedFront"';};?>><?php echo $cate->text;?></a></li>
		<?php endforeach;?>
	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $currentCate->text;?></h2>
		<p class="crumbs">您的位置：<a href="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>0,'pcode'=>$parent->code])?>"><?php echo $parent->codeDesc;?></a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$parent->id,'cateid'=>$currentCate->id,'pcode'=>$parent->code])?>"><?php echo $currentCate->text;?></a></p>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<div class="newsList">
			<ul>
			<?php if(empty($list['data'])):?>
					<li>抱歉！暂时没有此类型的新闻</li>
			<?php endif;?>
			<?php foreach ($list['data'] as $val):?>
				<!-- 特别的类型数据 -->
    			<?php if($currentCate->cateCode == CategoryType::ZKJS || $currentCate->cateCode == CategoryType::XRLD || $currentCate->cateCode == CategoryType::SZQK || $currentCate->cateCode == CategoryType::XYFC):?>
    				<li class="personage-item">
    					<img alt="" src="<?php echo $val['photo']?>">
    					<div class="personage-info">
        					<h4><?php echo $val['fullName'];?> <?php echo $val['duties'];?></h4>
        					<hr/>
        					<p><?php echo str_replace("\r\n", '<br/>', $val['intruduce']);?></p>
    					</div>
    				<li>
    			<?php elseif ($currentCate->cateCode == CategoryType::WYBM):?>
    				<li class="gradeclass-item">
    					<div class="bms">
    						<a href="<?php echo  Url::to(['student/joinup','cid'=>$val['id']])?>"><?php echo $val['className']?></a>
    						<p>距离报名结束还有<font style="color:red;"><?php $c=time();$e = strtotime($val['joinEndDate'].' 23:59:59'); echo intval(($e-$c)/86400); ?>天<?php echo intval((($e-$c)%86400)/3600)?>小时</font></p>
    					</div>
    					<div class="bmx">
    						报名时间：<?php echo date('Y年m月d日',strtotime($val['joinStartDate']));?> - <?php echo date('Y年m月d日',strtotime($val['joinEndDate']));?> ，开班时间：<?php echo date('Y年m月d日',strtotime($val['openClassTime']));?>
    						<span style="float:right;">教务员：<?php echo $val['eduAdmin'];?>&nbsp;<?php echo $val['eduAdminPhone'];?></span>
    						<br/>
    						<?php if(TestPaper::checkExistByGradeClassId($val['id'])):?>
    						<a href="<?php echo Url::to(['student/testpapers','cid'=>$val['id']])?>" ><b style="color: #333;font-weight: inherit;">【相关测评试卷】</b></a>
    						<?php endif;?>
    						<a href="<?php echo Url::to(['student/joinup','cid'=>$val['id']])?>"><b >【进入报名】</b></a>
    					</div>
    				</li>
    			<?php elseif ($currentCate->cateCode == CategoryType::TPDC):?>
    				<li class="article-item">
    				<a href="<?php echo Url::to(['student/naire','id'=>$val['id']])?>" title="<?php echo $val['title'];?>"><?php echo MyHelper::timestampToDate($val['modifyTime'],'Y-m-d');?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['title'];?></a></li>
    			<?php elseif ($currentCate->cateCode == CategoryType::KBCX):?>
    				<li class="article-item">
    				<a href="<?php echo Url::to(['schedule/info','id'=>$val['id']])?>" title="<?php echo $val['title'];?>">【<?php echo $val['gradeClass'];?>】 <?php echo $val['title'];?></a>
    				</li>
    				
    			<?php elseif($currentCate->cateCode == CategoryType::MMST):?>
    				
    				<li class="mmst-item">
    					<a  href="javascript:;" class="dialog" data-tagget-url="<?php echo Url::to(['famous-teacher/showinfo','id'=>$val['id']])?>">
            				<div style="width: 75px;text-align:center;">
            					<img alt="" src="<?php echo $val['avater'];?>" width="75px" height="125px">
            					<p class="mmst-name" style="margin-top: 10px;margin-bottom: 10px;font-size: 16px;color: #191919;font-weight: 600;"><?php echo $val['name'];?></p>
            				</div>
            			</a>
    				</li>
    				
    				
    			<?php else :?>
    				<?php if ($currentCate->type == CategoryType::ARTICLE):?>
    					<li class="article-item"><a target="_blank" href="<?php echo Url::to(['news/detail','id'=>$val['id']])?>" title="<?php echo $val['title'];?>"><?php echo MyHelper::timestampToDate($val['publishTime'],'Y-m-d');?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mb_substr($val['title'],0,41,'utf-8');?>&nbsp;&nbsp</a><?php if($val['publishTime'] > (time() - 5*24*3600)):?><img alt="热点新闻" src="/front/img/index/hot_news.gif"><?php endif;?></li>
    				<?php elseif ($currentCate->type == CategoryType::VIDEO):?>
    					<li  class="video-item" data-videourl="<?php echo $val['video'];?>" data-videotype="<?php echo $val['videoType'];?>" id="video_item_<?php echo $val['id'];?>">
        					<a href="javascript:;">
                    			<img src="<?php echo $val['videoImg'];?>" />
                    			<p><?php echo $val['descr'];?></p>
                    			<span class="video-btn"></span>
        					</a>
    					</li>
    				<?php elseif ($currentCate->type == CategoryType::IMAGE):?>
    					<li  class="image-item">
        					<a href="<?php echo !empty($val['link']) ? $val['link'] : 'javascript:;';?>">
                    			<p class="image-box"><img src="<?php echo $val['photo'];?>"  class="<?php echo empty($val['link']) ? 'img-rounded' :''; ?>"/></p>
                    			<p><?php echo $val['title'];?></p>
        					</a>
    					</li>
    				<?php elseif ($currentCate->type == CategoryType::FILE):?>
    					<li class="file-item">
    						<a href="<?php echo $val['uri'];?>" title="<?php echo $val['descr'];?>"><?php echo MyHelper::timestampToDate($val['modifyTime'],'Y-m-d');?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['descr'];?></a>
    					</li>
    				<?php endif;?>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
			
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
AppAsset::addCss($this, '/front/css/pagination.css');
AppAsset::addCss($this, '/front/js/zoomify/zoomify.min.css');
AppAsset::addScript($this, '/front/js/jquery.pagination.js');

AppAsset::addScript($this, '/front/js/zoomify/zoomify.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$js = <<<JS
initPagination({
	el : "#Pagination",
	count : $count,
	curPage : $curPage,
	pageSize : $pageSize,
    uri : '$uri'
});
//视频播放
$(document).on('click','.video-item',function(){
	if($(this).hasClass('prism-player')){
		return false;
	}
	var source = $(this).data('videourl');
    var videoType = $(this).data('videotype');
	//远程视频链接
	if(videoType == 2){
		window.open(source);
		return false;
	}
	var id = $(this).attr('id');
	var player = new Aliplayer({
            id: id,
            width: '267px',
			height: '170px',
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

$('.img-rounded').zoomify({
	scale : 4,
});

JS;
$css = <<<CSS
.newsList .video-item{margin-bottom:15px;}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>