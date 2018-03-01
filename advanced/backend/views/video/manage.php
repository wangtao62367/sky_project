<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use backend\assets\AppAsset;
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">新闻系统</a></li>
    <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
    <li><a href="<?php echo Url::to(['video/manage'])?>">视频列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
   
    <?php echo Html::beginForm(Url::to(['video/manage']),'get');?>
    	<ul class="seachform">
    		<li><label>视频名称</label><?php echo Html::activeTextInput($model, 'search[descr]',['class'=>'scinput'])?></li>
	        <li>
	            <label>分类</label>  
	            <div class="vocation">
	                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
	            </div>
	        </li>
	        <li><label>视频提供者</label><?php echo Html::activeTextInput($model, 'search[provider]',['class'=>'scinput'])?></li>
	        <li><label>添加时间</label>
	        <?php echo Html::activeTextInput($model, 'search[createTimeStart]',['class'=>'scinput','id'=>'createTimeStart','placeholder'=>'开始时间'])?> - 
	        <?php echo Html::activeTextInput($model, 'search[createTimeEnd]',['class'=>'scinput','id'=>'createTimeEnd','placeholder'=>'结束时间'])?></li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li class="click"><a href="<?php echo Url::to(['video/add'])?>" class="add-btn">添加</a></li>
<!--         	<li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li> -->
        </ul>
        <?php echo Html::endForm();?>
 </div>
<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、视频背景图建议大小为：宽280像素*高185像素。</li>
	</ul>
</div>
   
	<table class="tablelist">
    
	    <thead>
		    <tr>
		    <th><input name="" type="checkbox" class="s-all" /></th>
		    <th width="300px;">视频</th>
		    <th>视频名称</th>
		    <th>视频分类</th>
		    <th>提供者</th>
		    <th>院领导</th>
		    <th>预览量</th>
		    <th>创建时间</th>
            <th>修改时间</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    	<?php foreach ($list['data'] as $val):?>
		    <tr>
		    <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
		    <td class="imgtd"><img src="<?php echo $val['videoImg']?>" /></td>
		    <td><?php echo $val['descr'];?></td>
		    <td><?php echo $val['categorys']['text'];?></td>
		    <td><?php echo $val['provider'];?></td>
		    <td><?php echo $val['leader'];?></td>
		    <td><?php echo $val['readCount'];?></td>
		    <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
		    <td>
		    <a href="<?php echo Url::to(['video/edit','id'=>$val['id']])?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Url::to(['video/del','id'=>$val['id']])?>">删除</a>
		    </td>
		    </tr>
		    <?php endforeach;?>
	    	 <?php if($list['count'] == 0):?>
        			<tr><td colspan="10" class="data-empty" >暂时没有数据</td></tr>
        	<?php endif;?>
	    </tbody>
    
    </table>
	<div class="pagination">
	    <div style="float: left">总共有 <?php echo $list['count'];?> 条数据</div>
	    <!-- 这里显示分页 -->
	    <div id="Pagination"></div>
	</div>
	


<?php 
$uri = Yii::$app->request->getUrl();
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$css =<<<CSS
.imgtd img{
    height: 185px;
    width: 280px;
}
CSS;
$js= <<<JS
initPagination({
	el : "#Pagination",
	count : $count,
	curPage : $curPage,
	pageSize : $pageSize,
    uri : '$uri'
});
//时间选择框
var now = new Date();
var yearEnd = now.getFullYear();
var yearStart = yearEnd - 10;
var maxDate = now.setFullYear(yearEnd);
$.datetimepicker.setLocale('ch');
$('#createTimeStart').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      maxDate : now,
      maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:false    //开启选择今天按钮
});

$('#createTimeEnd').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      maxDate : now,
      maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

JS;
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>