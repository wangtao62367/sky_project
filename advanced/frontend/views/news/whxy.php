<?php


use frontend\assets\WhxyAsset;
use yii\helpers\Url;

$this->title = '文化学院';
?>

<img class="whjl-banner" src="/front/img/news/whxy_top.jpg" />

<div class="whxy-jj">
<img class="title-img" src="/front/img/news/whxy_title.png" />
<h2>四川省中华文化学院简介</h2>
<?php echo $data['info']['text'];?>
</div>

<div class="whxy-news">
    <div class="whxy-whgs"> 
        <img class="title-img" alt="" src="/front/img/news/whxy_tzgs.png">
        <ul style="margin-left:152px;">
        	<?php foreach ($data['tzgs'] as $val):?>
        	<li>
        		<a href="<?php echo Url::to(['news/detail','id'=>$val->id])?>" title="<?php echo $val->title ;?>">
            		<div class="news-img-box">
            			<img alt="" src="<?php echo $val->titleImg; ?>" width="135px" height="85px"/>
            		</div>
            		<div class="news-intro">
            			<h4><?php echo $val->title;?></h4>
            			<p><?php echo $val->summary;?></p>
            		</div>
        		</a>
        	</li>
        	<?php endforeach;?>

        </ul>
        <?php if(count($data['tzgs']) > 0):?>
        <a class="more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'tzgs']);?>" title="查看更多统战故事">&gt;&gt;更多</a>
        <?php endif;?>
    </div>
    
    <div class="whxy-wxsh">
    	<img class="title-img" alt="" src="/front/img/news/whxy_wxsh.png">
   		<ul style="margin-left:152px;">
   			<?php foreach ($data['wxsh'] as $val):?>
        	<li>
        		<a href="<?php echo Url::to(['news/detail','id'=>$val->id])?>" title="<?php echo $val->title ;?>">
            		<div class="news-img-box">
            			<img alt="" src="<?php echo $val->titleImg; ?>" width="135px" height="85px"/>
            		</div>
            		<div class="news-intro">
            			<h4><?php echo $val->title;?></h4>
            			<p><?php echo $val->summary;?></p>
            		</div>
        		</a>
        	</li>
        	<?php endforeach;?>
        </ul>
        <?php if(count($data['wxsh']) > 0):?>
        <a class="more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'wxsh']);?>" title="查看更多文学书画">&gt;&gt;更多</a>
        <?php endif;?>
    </div>
</div>
<div class="whxy-news">
    <div class="whxy-whjl"> 
    <img class="title-img" alt="" src="/front/img/news/whxy_whjl.png">
    <?php if(!empty($data['whjl'])):?>
    <a href="<?php echo Url::to(['news/detail','id'=>$data['whjl'][0]['id']]);?>" title="查看详情"><h2><?php echo $data['whjl'][0]['title'];?></h2>
    <p><?php echo $data['whjl'][0]['summary'];?></p>
    </a>
    <?php endif;?>
    <ul style="">
    <?php foreach ($data['whjl'] as $k=>$whjl):?>
    <?php if($k > 0):?>
    <li><a href="<?php echo Url::to(['news/detail','id'=>$whjl['id']]);?>" title="<?php echo $whjl['title'];?>"><?php echo $whjl['title'];?></a></li>
    <?php endif;?>
    <?php endforeach;?>
    </ul>
    <?php if(count($data['whjl']) > 0):?>
    <a class="more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'whjl']);?>" title="查看更多文学交流">&gt;&gt;更多</a>
    <?php endif;?>
    </div>
    <div class="whxy-whlt">
    <img class="title-img" alt="" src="/front/img/news/whxy_whlt.png">
    <?php if(!empty($data['whlt'])):?>
    <a href="<?php echo Url::to(['news/detail','id'=>$data['whlt'][0]['id']]);?>" title="查看详情"><h2><?php echo $data['whlt'][0]['title'];?></h2>
    <p><?php echo $data['whlt'][0]['summary'];?></p>
    </a>
    <?php endif;?>
    <ul style="">
    <?php foreach ($data['whlt'] as $k=>$whlt):?>
    <?php if($k > 0):?>
    <li><a href="<?php echo Url::to(['news/detail','id'=>$whlt['id']]);?>" title="<?php echo $whlt['title'];?>"><?php echo $whlt['title'];?></a></li>
    <?php endif;?>
    <?php endforeach;?>
    </ul>
    <?php if(count($data['whlt']) > 0):?>
    <a class="more" href="<?php echo Url::to(['news/list-by-catecode','code'=>'whlt']);?>" title="查看更多文化论坛">&gt;&gt;更多</a>
    <?php endif;?>
    </div>
</div>

<?php 
WhxyAsset::addCss($this, '/front/css/whxy.css');
$css = <<<CSS
.whxy-news .whxy-whjl, .whxy-news .whxy-whlt, .whxy-news .whxy-whgs, .whxy-news .whxy-wxsh {
    position: relative;
    overflow: visible;
    height: 295px;
}
.more{
    position:absolute;
    right: 0;
    bottom: 0;
}
.whxy-news a{color: #3B3B3B;}
CSS;
$this->registerCss($css);
?>