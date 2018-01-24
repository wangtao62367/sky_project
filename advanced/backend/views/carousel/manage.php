<?php


use yii\helpers\Url;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['carousel/manage'])?>">导航管理</a></li>
    </ul>
</div>

<div class="rightinfo">

<div class="tools">

<ul class="toolbar">
	<li class="click"><a href="<?php echo Url::to(['carousel/add'])?>" class="add-btn">添加</a></li>
    <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>

</ul>

</div>




    <table class="imgtable">
    
	    <thead>
		    <tr>
		    <th width="100px;">轮播图</th>
		    <th>链接地址</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    
		    <tr>
		    <td class="imgtd"><img src="/admin/images/img11.png" /></td>
		    <td><a href="#">非常不错的国外后台模板，支持HTML5</a><p>发布时间：2013-10-12 09:25:18</p></td>
		    <td>后台界面<p>ID: 82122</p></td>
		    </tr>
		    
		    <tr>
		    <td class="imgtd"><img src="/admin/images/img12.png" /></td>
		    <td><a href="#">一套简约形状图标UI下载</a><p>发布时间：2013-10-12 09:25:18</p></td>
		    <td>图标设计<p>ID: 82122</p></td>
		   
		    </tr>
		    
		    <tr>
		    <td class="imgtd"><img src="/admin/images/img13.png" /></td>
		    <td><a href="#">配色软件界面设计PSD下载</a><p>发布时间：2013-10-12 09:25:18</p></td>
		    <td>软件界面<p>ID: 82122</p></td>
		    
		    </tr>
	    
	    </tbody>
    
    </table>

</div>
    
 <?php 
 $css =<<<CSS
.imgtable{margin:0 auto;;margin-top:20px;width: 98%;}

CSS;
 
$this->registerCss($css);
 ?>