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
    <li><a href="<?php echo Url::to(['image/manage'])?>">图片列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    <?php echo Html::beginForm(Url::to(['image/manage']),'get');?>
    	<ul class="seachform">
    		<li><label>图片标题</label><?php echo Html::activeTextInput($model, 'search[title]',['class'=>'scinput'])?></li>
	        <li>
	            <label>分类</label>  
	            <div class="vocation">
	                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
	            </div>
	        </li>
	        <li><label>图片提供者</label><?php echo Html::activeTextInput($model, 'search[provider]',['class'=>'scinput'])?></li>
	        <li><label>添加时间</label>
	        <?php echo Html::activeTextInput($model, 'search[createTimeStart]',['class'=>'scinput','id'=>'createTimeStart','placeholder'=>'开始时间'])?> - 
	        <?php echo Html::activeTextInput($model, 'search[createTimeEnd]',['class'=>'scinput','id'=>'createTimeEnd','placeholder'=>'结束时间'])?></li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li class="click"><a href="<?php echo Url::to(['image/add'])?>" class="add-btn">添加</a></li>
        	<li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        </ul>
        <?php echo Html::endForm();?>
 </div>   
 
<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、图片建议大小为：宽267像素*高170像素。</li>
		<li>1、如其它分类下的图片需要链接跳转，需填写有效的链接地址。</li>
	</ul>
</div>

    <table class="tablelist">
    
	    <thead>
		    <tr>
		    <th><input name="" type="checkbox" class="s-all" /></th>
		    <th width="300px;">图片</th>
		    <th>图片标题</th>
		    <th>图片分类</th>
		    <th>链接地址</th>
		    <th>提供者</th>
		    <th>院领导</th>
		    <th>创建时间</th>
            <th>修改时间</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    	<?php foreach ($list['data'] as $val):?>
		    <tr>
		    <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
		    <td class="imgtd"><img src="<?php echo $val['photo']?>" /></td>
		    <td><?php echo $val['title'];?></td>
		    <td><?php echo $val['categorys']['text'];?></td>
		    <td><?php echo $val['link'];?></td>
		    <td><?php echo $val['provider'];?></td>
		    <td><?php echo $val['leader'];?></td>
		    <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
		    <td class="handle-box">
		    <a href="<?php echo Url::to(['image/edit','id'=>$val['id']])?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Url::to(['image/del','id'=>$val['id']])?>">删除</a>
		    </td>
		    </tr>
		    <?php endforeach;?>
	    
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
$batchDelUrl = Url::to(['image/batchdel']);
$css = <<<CSS
.imgtd img{
    height: 185px;
    width: 280px;
}
CSS;
$js= <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
});
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