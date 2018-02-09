<?php

use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->title= $data['current']['title'];
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$data['crumbs']['parentId'],'cateid'=>0])?>"><?php echo $data['crumbs']['codeDesc'];?></a>&nbsp;&gt;&nbsp;<a href="<?php echo Url::to(['news/list','pid'=>$data['crumbs']['parentId'],'cateid'=>$data['crumbs']['id']])?>"><?php echo $data['crumbs']['text'];?></a></p>
<h2><?php echo $data['current']['title'];?></h2>
<div class="inst">
	<ul>
		<li>来源：<a href="<?php echo empty($data['current']['sourceLinke'])? '#' : $data['current']['sourceLinke'];?>"><?php echo empty($data['current']['sourceLinke'])? $this->params['webCfgs']['siteName']:$data['current']['source'];?></a></li>
		<li class="second">作者：中央社院微信公众号</li>
		<li>
		<p>分享到：</p>
		<div  class="bdsharebuttonbox">
			<a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
		</div>
		</li>
	</ul>
</div>
<hr/>
<div class="content">
	<?php echo $data['current']['content'];?>
</div>
<div class="upAndDown">
	<p class="left">上一篇：<a href="<?php echo empty($data['pre']) ? 'javascript:;' : Url::to(['news/detail','id'=>$data['pre']['id']])?>"><?php echo empty($data['pre']) ? '已经是第一篇了':$data['pre']['title'];?></a></p>
	<p class="right">下一篇：<a href="<?php echo empty($data['next']) ? 'javascript:;' : Url::to(['news/detail','id'=>$data['next']['id']])?>"><?php echo empty($data['next']) ? '已经是最后一篇了':$data['next']['title'];?></a></p>
</div>
<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFrontPage.css');
$js =<<<JS
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
JS;
$this->registerJs($js);
?>
