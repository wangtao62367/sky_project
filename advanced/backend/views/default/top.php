<?php

use yii\helpers\Url;

$this->title = 'top';
?>
    <div class="topleft">
    <a href="<?php echo Url::to(['default/index'])?>" target="_parent"><h1>社会主义学员后台管理系统</h1></a>
    </div>
        
    <!--<ul class="nav">
    <li><a href="default.html" target="rightFrame" class="selected"><img src="images/icon01.png" title="工作台" /><h2>工作台</h2></a></li>
    <li><a href="imgtable.html" target="rightFrame"><img src="images/icon02.png" title="模型管理" /><h2>模型管理</h2></a></li>
    <li><a href="imglist.html"  target="rightFrame"><img src="images/icon03.png" title="模块设计" /><h2>模块设计</h2></a></li>
    <li><a href="tools.html"  target="rightFrame"><img src="images/icon04.png" title="常用工具" /><h2>常用工具</h2></a></li>
    <li><a href="computer.html" target="rightFrame"><img src="images/icon05.png" title="文件管理" /><h2>文件管理</h2></a></li>
    <li><a href="tab.html"  target="rightFrame"><img src="images/icon06.png" title="系统设置" /><h2>系统设置</h2></a></li>
    </ul>-->
            
    <div class="topright">    
    <ul>
    <!--<li><span><img src="images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>-->
    <li><a href="<?php echo Url::to(['public/logout']);?>" target="_parent">退出</a></li>
    </ul>
     
    <div class="user">
    <span><?php echo Yii::$app->user->identity->account;?></span>
<!--     <i>消息</i>
    <b>5</b> -->
    </div>    
    
    </div>
<?php 
$js = <<<JS
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
JS;
$css = <<<CSS
body{background:url(/admin/images/topbg.gif) repeat-x;}
.topleft h1{color: #fff;font-size: 25px;line-height: 88px;padding-left: 20px;}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>

