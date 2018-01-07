<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">新闻系统</a></li>
    <li><a href="<?php echo Url::to(['image/manage'])?>">内容管理</a></li>
    <li><a href="<?php echo Url::to(['image/manage'])?>">图片列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="seachform">
    		<li><label>图片名称</label><?php echo Html::activeTextInput($model, 'search[descr]',['class'=>'scinput'])?></li>
	        <li>
	            <label>分类</label>  
	            <div class="vocation">
	                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
	            </div>
	        </li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li><a href="<?php echo Url::to(['article/create'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        	<li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        </ul>
        
        
<!--         <ul class="toolbar1"> -->
<!--         <li><span><img src="/admin/images/t05.png" /></span>设置</li> -->
<!--         </ul> -->
    
    </div>
    
    
	<ul class="imglist">
	    
	    <li class="selected">
	    <span><img src="/admin/images/img01.png" /></span>
	    <h2><a href="#">软件界面设计下载</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img02.png" /></span>
	    <h2><a href="#">界面样式素材下载</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img03.png" /></span>
	    <h2><a href="#">弹出小窗口界面设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img04.png" /></span>
	    <h2><a href="#">羽毛图标设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img05.png" /></span>
	    <h2><a href="#">日历组件样式设计</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img06.png" /></span>
	    <h2><a href="#">羽毛图标设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img07.png" /></span>
	    <h2><a href="#">弹出小窗口界面设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img08.png" /></span>
	    <h2><a href="#">弹出小窗口界面设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img09.png" /></span>
	    <h2><a href="#">弹出小窗口界面设计教程</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	    <li>
	    <span><img src="/admin/images/img10.png" /></span>
	    <h2><a href="#">软件界面设计下载</a></h2>
	    <p><a href="#">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">删除</a></p>
	    </li>
	    
	</ul>

</div>