<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['download/manage'])?>">下载列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['download/manage']),'get');?>
	<ul class="seachform">
        <li><label>文件名称</label><?php echo Html::activeTextInput($model, 'search[descr]',['class'=>'scinput'])?></li>
        <li><label>文件类型</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li><label>文件提供者</label><?php echo Html::activeTextInput($model, 'search[provider]',['class'=>'scinput'])?></li>
        <li><label>添加时间</label>
        <?php echo Html::activeTextInput($model, 'search[createTimeStart]',['class'=>'scinput','id'=>'createTimeStart','placeholder'=>'开始时间'])?> - 
        <?php echo Html::activeTextInput($model, 'search[createTimeEnd]',['class'=>'scinput','id'=>'createTimeEnd','placeholder'=>'结束时间'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['download/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        <li><a href="javascript:;" class="export-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>文件名称</th>
            <th>链接地址</th>
            <th>文件类型</th>
            <th>提供者</th>
            <th>院领导</th>
            <th>下载量</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['descr'];?></td>
            <td><?php echo $val['uri'];?></td>
            <td><?php echo $val['categorys']['text'];?></td>
            <td><?php echo $val['provider'];?></td>
            <td><?php echo $val['leader'];?></td>
            <td><?php echo $val['loadCount'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['download/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['download/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<div class="pagination">
    <div style="float: left"><span>总共有 <?php echo $list['count'];?> 条数据</span></div>
    <!-- 这里显示分页 -->
    <div id="Pagination"></div>
</div>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['download/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['download/export']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
})

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

//导出
$(document).on('click','.export-btn',function(){
    var form = $(this).parents('form')[0];
    $(form).attr('action','$exportUrl');
    $(form).submit();
})
JS;
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>