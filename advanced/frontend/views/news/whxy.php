<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;

?>

<img class="whjl-banner" src="/front/img/news/whxy_top.jpg" />

<div class="whxy-jj">
<img src="/front/img/news/whxy_title" />
<h2>四川省中华文化学院简介</h2>
<p>为适应向港澳台和外侨胞传播中华文化的需要，经中央有关部门批准，中央社会主义学院加挂“中华文化学院”牌子成为我国唯一一所以“中华文化”命名的中央级教育机构。成立以来，中华文化学院始终坚持正确的政治方向，高举爱国主义旗帜，以“中华文化”为纽带和载体，以团结港澳台和海外侨胞为着力点，积极探索、不断开拓，努力弘扬中华文化，取得了显著成绩。</p>
<p>20年来，中华文化学院坚持不懈开展对港澳台青年精英、海外华人华侨、国际友人的交流与研修，逐渐打造出“台湾大学生中华文化研习营” “国情研修班”等一批教学品牌，以及“中华文化论坛”等学术交流品牌，初步形成文化研修和文化交流相结合的教学模式。迄今为止，已成功组织了1.6万名台湾学生到大陆研习考察。</p>
</div>
<img class="whjl-banner" src="/front/img/news/whxy_banner.jpg" />
<div class="whxy-news">
<div class="whxy-whjl"> 
<img alt="" src="/front/img/news/whxy_whjl.png">
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
</div>
<div class="whxy-whlt">
<img alt="" src="/front/img/news/whxy_whlt.png">
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
</div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/whxy.css');
?>