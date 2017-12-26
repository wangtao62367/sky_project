<?php

use yii\helpers\Url;

$this->title = '左侧导航';
?>
	<div class="lefttop"><span></span>控制台</div>
    
    <dl class="leftmenu">
        
    <dd>
	    <div class="title">
	    	<span><img width="16px" src="/admin/images/t05.png" /></span>系统设置
	    </div>
    	<ul class="menuson">
	        <li class="active"><cite></cite><a href="index.html" target="rightFrame">基础配置</a><i></i></li>
	        <li><cite></cite><a href="right.html" target="rightFrame">管理员管理</a><i></i></li>
	        <li><cite></cite><a href="imgtable.html" target="rightFrame">权限管理</a><i></i></li>
	        <li><cite></cite><a href="form.html" target="rightFrame">添加编辑模板</a><i></i></li>
	        <li><cite></cite><a href="imglist.html" target="rightFrame">图片列表</a><i></i></li>
	        <li><cite></cite><a href="imglist1.html" target="rightFrame">图片列表2</a><i></i></li>
	        <li><cite></cite><a href="tools.html" target="rightFrame">工具图标</a><i></i></li>
	        <li><cite></cite><a href="filelist.html" target="rightFrame">信息管理</a><i></i></li>
	        <li><cite></cite><a href="tab.html" target="rightFrame">Tab页</a><i></i></li>
	        <li><cite></cite><a href="error.html" target="rightFrame">404页面</a><i></i></li>
        </ul>    
    </dd>
        
    
    <dd>
	    <div class="title">
	    <span><img width="16px" src="/admin/images/i06.png" /></span>新闻系统
	    </div>
    	<ul class="menuson">
	        <li><cite></cite><a href="<?php echo  Url::to(['content/manage'])?>" target="rightFrame">内容管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#" >分类管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">测评试卷</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">调查管理</a><i></i></li>
        </ul>     
    </dd> 
    
    
    <dd>
    	<div class="title"><span><img width="16px" src="/admin/images/icon01.png" /></span>教务系统</div>
	    <ul class="menuson">
	        <li><cite></cite><a target="rightFrame" href="#">课表管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">课程管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">教师管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">班级管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">教学点管理</a><i></i></li>
	    </ul>    
    </dd>  
    
    
    <dd><div class="title"><span><img width="16px" src="/admin/images/i07.png" /></span>用户系统</div>
    <ul class="menuson">
        <li><cite></cite><a target="rightFrame" href="#">用户管理</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="#">学员管理</a><i></i></li>
    </ul>
    
    <dd><div class="title"><span><img width="16px" src="/admin/images/ico03.png" /></span>统计系统</div>
	    <ul class="menuson">
	        <li><cite></cite><a target="rightFrame" href="#">学员统计</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="#">答题统计</a><i></i></li>
	    </ul>
    </dd>   
    
    </dl>
<?php 
$js = <<<JS
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if(ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
JS;
$css = <<<CSS
body{style="background:#f0f9fd;"}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>