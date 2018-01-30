<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Common;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['personage/manage'])?>">社院人物管理</a></li>
        <li><a href="<?php echo Url::to(['personage/manage'])?>">人物列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['personage/manage']),'get');?>
	<ul class="seachform">
        <li><label>姓名</label>
        <?php echo Html::activeTextInput($model, 'search[fullName]',['class'=>'scinput','placeholder'=>'姓名'])?>
        </li>
        <li><label>人物角色</label>
        <?php echo Html::activeTextInput($model, 'search[role]',['class'=>'scinput','placeholder'=>'教学点联络人'])?>
        </li>
        <li>
        	<label>创建时间</label>
        	<?php echo Html::activeTextInput($model, 'search[startTime]',['class'=>'scinput startTime','placeholder'=>'开始时间'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[endTime]',['class'=>'scinput endTime','placeholder'=>'结束时间'])?>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['personage/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <!-- <li><a href="javascript:;" class="excel-btn">导出</a></li> -->
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input type="checkbox" class="s-all" value="" /></th>
            <th>姓名</th>
            <th>人物角色</th>
            <th>职务</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" type="checkbox" class="item" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['fullName'];?></td>
            <td><?php echo $val['role']['codeDesc'];?></td>
            <td><?php echo $val['duties'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['personage/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['personage/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['personage/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['personage/export']);
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
$('.startTime').datetimepicker({
      format:"Y-m-d H:i:s",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:false    //开启选择今天按钮
});

$('.endTime').datetimepicker({
      format:"Y-m-d H:i:s",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
//导出
// $(document).on('click','.excel-btn',function(){
//     var form = $(this).parents('form')[0];
//     $(form).attr('action','$exportUrl');
//     $(form).submit();
// })
JS;
$this->registerJs($js);
$this->registerCss($css);
?>