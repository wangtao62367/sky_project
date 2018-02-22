<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\publics\MyHelper;
use common\models\CategoryType;
use common\models\TestPaper;

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
				<!-- 特别的类型数据 -->
    			<?php if($currentCate->cateCode == CategoryType::KZJS || $currentCate->cateCode == CategoryType::XRLD):?>
    				<li class="personage-item">
    					<img alt="" src="<?php echo $val['photo']?>">
    					<h4><?php echo $val['fullName'];?> <?php echo $val['duties'];?></h4>
    					<hr/>
    					<p><?php echo str_replace("\r\n", '<br/>', $val['intruduce']);?></p>
    				<li>
    			<?php elseif ($currentCate->cateCode == CategoryType::WYBM):?>
    				<li class="gradeclass-item">
    					<div class="bms">
    						<a href="<?php echo  Url::to(['student/joinup'])?>"><?php echo $val['className']?></a>
    						<p>距离报名结束还有<?php $c=time();$e = strtotime($val['joinEndDate'].' 23:59:59'); echo intval(($e-$c)/86400); ?>天<?php echo intval((($e-$c)%86400)/3600)?>小时</p>
    					</div>
    					<div class="bmx">
    						报名时间：<?php echo date('Y年m月d日',strtotime($val['joinStartDate']));?> -> <?php echo date('Y年m月d日',strtotime($val['joinEndDate']));?> ，交费时间：<?php echo date('Y年m月d日',strtotime($val['openClassTime']));?>
    						<br/>
    						<?php if(TestPaper::checkExistByGradeClassId($val['id'])):?>
    						<a href="<?php echo Url::to(['student/testpapers','cid'=>$val['id']])?>" ><b style="color: #333;font-weight: inherit;">【相关测评试卷】</b></a>
    						<?php endif;?>
    						<a href="<?php echo Url::to(['student/joinup','cid'=>$val['id']])?>"><b >【进入报名】</b></a>
    					</div>
    				</li>
    			<?php elseif ($currentCate->cateCode == CategoryType::TPDC):?>
    				<li class="article-item">
    				<a href="<?php echo Url::to(['student/naire','id'=>$val['id']])?>" title="<?php echo $val['title'];?>"><?php echo MyHelper::timestampToDate($val['modifyTime']);?>  <?php echo $val['title'];?></a></li>
    			<?php else :?>
    				<?php if ($currentCate->type == CategoryType::ARTICLE):?>
    					<li class="article-item"><a href="<?php echo Url::to(['news/detail','id'=>$val['id']])?>" title="<?php echo $val['title'];?>"><?php echo MyHelper::timestampToDate($val['publishTime']);?>  <?php echo $val['title'];?></a></li>
    				<?php elseif ($currentCate->type == CategoryType::VIDEO):?>
    					<li  class="video-item" data-videourl="<?php echo $val['video'];?>" id="video_item_<?php echo $val['id'];?>">
        					<a href="javascript:;">
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
AppAsset::addScript($this, '/front/js/jquery.pagination.js');
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
$(document).on('click','.video-item',function(){
	if($(this).hasClass('prism-player')){
		return false;
	}
	var source = $(this).data('videourl');
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
JS;
$this->registerJs($js);
?>