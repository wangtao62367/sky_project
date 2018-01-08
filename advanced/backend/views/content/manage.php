<?php

use yii\helpers\Url;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
	    <li><a href="javascript:;">新闻系统</a></li>
	    <li><a href="<?php Url::to(['content/manage'])?>">内容管理</a></li>
    </ul>
</div>
    
<div class="formbody">
	<div class="formtitle"><span>基础数据</span></div>

    <div class="toolsli">
	    <ul class="toollist">
		    <li><a href="<?php echo Url::to(['nav/manage'])?>"><img src="/admin/images/i01.png" /></a><h2>首页导航</h2></li>
		    <li><a href="<?php echo Url::to(['bottomlink/manage'])?>"><img src="/admin/images/i04.png" /></a><h2>底部链接</h2></li>
	    </ul>
    </div>

    <div class="formtitle"><span>主要内容</span></div>
    
    <div class="toolsli">
	    <ul class="toollist">
		    <li><a href="<?php echo Url::to(['article/articles'])?>"><img src="/admin/images/i06.png" /></a><h2>文章模块</h2></li>
		    <li><a href="<?php echo Url::to(['image/manage'])?>"><img src="/admin/images/i07.png" /></a><h2>图片模块</h2></li>
		    <li><a href="<?php echo Url::to(['video/manage'])?>"><img src="/admin/images/i08.png" /></a><h2>视频中心</h2></li>
		    <li><a href="<?php echo Url::to(['download/manage'])?>"><img src="/admin/images/i09.png" /></a><h2>下载中心</h2></li>      
	    </ul>
    </div>
</div>