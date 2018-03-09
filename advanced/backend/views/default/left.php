<?php

use yii\helpers\Url;

$this->title = '左侧导航';
?>
	<div class="lefttop"><a target="rightFrame" href="<?php echo Url::to(['default/main'])?>"><span></span>控制台</a></div>
    
    <dl class="leftmenu">
        
    <dd>
	    <div class="title">
	    	<span><img width="16px" src="/admin/images/t05.png" /></span>管理员系统
	    </div>
    	<ul class="menuson">
    		<li><cite></cite><a href="<?php echo Url::to(['admin/manage'])?>" target="rightFrame">管理员管理</a><i></i></li>
    		<li><cite></cite><a href="<?php echo Url::to(['rbac/roles']);?>" target="rightFrame">权限管理</a><i></i></li>
	        <li><cite></cite><a href="<?php echo Url::to(['web/setting']);?>" target="rightFrame">基础配置</a><i></i></li>
	        <!-- <li><cite></cite><a href="right.html" target="rightFrame">管理员管理</a><i></i></li>
	        <li><cite></cite><a href="imgtable.html" target="rightFrame">权限管理</a><i></i></li>
	        <li><cite></cite><a href="form.html" target="rightFrame">添加编辑模板</a><i></i></li>
	        <li><cite></cite><a href="imglist.html" target="rightFrame">图片列表</a><i></i></li>
	        <li><cite></cite><a href="imglist1.html" target="rightFrame">图片列表2</a><i></i></li>
	        <li><cite></cite><a href="tools.html" target="rightFrame">工具图标</a><i></i></li>
	        <li><cite></cite><a href="filelist.html" target="rightFrame">信息管理</a><i></i></li>
	        <li><cite></cite><a href="tab.html" target="rightFrame">Tab页</a><i></i></li>
	        <li><cite></cite><a href="error.html" target="rightFrame">404页面</a><i></i></li> -->
        </ul>    
    </dd>
    
    <dd><div class="title"><span><img width="16px" src="/admin/images/i07.png" /></span>用户管理系统</div>
    <ul class="menuson">
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['user/manage'])?>">用户管理</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['student/manage'])?>">学员管理</a><i></i></li>
    </ul>
    
    <dd><div class="title"><span><img width="16px" src="/admin/images/i07.png" /></span>网站管理系统</div>
    <ul class="menuson">
    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['adv/manage'])?>">广告设置</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['nav/manage'])?>">导航设置</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['educationbase/manage'])?>">教育基地设置</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['carousel/manage'])?>">首页轮播</a><i></i></li>  
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['bottomlink/manage'])?>">底部链接</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['bottomcate/manage'])?>">底部链接分类</a><i></i></li>
        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['content/schoole'])?>">学院信息录入</a><i></i></li>
        <!-- <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['personage/manage'])?>">社院人物</a><i></i></li>-->
    </ul>
    
    <dd>
	    <div class="title">
	    <span><img width="16px" src="/admin/images/i06.png" /></span>新闻管理系统
	    </div>
    	<ul class="menuson">
	        <li><cite></cite><a target="rightFrame" href="<?php echo  Url::to(['content/manage'])?>">内容管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="<?php echo  Url::to(['category/manage'])?>" >分类管理</a><i></i></li>
        </ul>     
    </dd> 
    
    
    <dd>
    	<div class="title"><span><img width="16px" src="/admin/images/icon01.png" /></span>教务管理系统</div>
	    <ul class="menuson">
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['student/verify-list'])?>">在线报名审核</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['gradeclass/manage'])?>">班级管理</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['teacher/manage'])?>">教师管理</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['curriculum/manage'])?>">课程管理</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['teachplace/manage'])?>">教学点管理</a><i></i></li>
	    	<li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['testpaper/manage'])?>">试卷管理</a><i></i></li>
	        <li><cite></cite><a target="rightFrame" href="<?php echo Url::to(['naire/manage'])?>">调查管理</a><i></i></li>
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
.lefttop a,.lefttop a:hover,.lefttop a:focus {
    text-decoration: none;
    color: #FFF;
    outline: none;
    blr: expression(this.onFocus=this.blur());
    font-size: 16px;
}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>
