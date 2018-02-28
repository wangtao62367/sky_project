<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['teacher/manage'])?>">教师管理</a></li>
        <li><a href="<?php echo Url::to(['teacher/manage'])?>">教师列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['teacher/manage']),'get');?>
	<ul class="seachform">
        <li><label>教师姓名</label><?php echo Html::activeTextInput($model, 'search[trueName]',['class'=>'scinput'])?></li>
        <li><label>教师性别</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[sex]', ['1'=>'男','2'=>'女'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>来源情况</label>
        <?php echo Html::activeTextInput($model, 'search[from]',['class'=>'scinput'])?>
        </li>
        <li>
        	<label>创建时间</label>
        	<?php echo Html::activeTextInput($model, 'search[startTime]',['class'=>'scinput startTime','placeholder'=>'开始时间'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[endTime]',['class'=>'scinput endTime','placeholder'=>'结束时间'])?>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['teacher/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <li><a href="javascript:;" class="excel-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>教师姓名</th>
            <th>手机号</th>
            <th>性别</th>
            <th>教师职称</th>
            <th>行政职务</th>
            <th>来源情况</th>
            <th>授课专题</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['trueName'];?></td>
            <td><?php echo $val['phone'];?></td>
            <td><?php echo $val['sex'] == 1 ? '男':'女';?></td>
            <td><?php echo $val['positionalTitles'];?></td>
            <td><?php echo $val['duties'];?></td>
            <td><?php echo $val['from'];?></td>
            <td><?php echo $val['teachTopics'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['teacher/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['teacher/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['teacher/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['teacher/export']);
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
$(document).on('click','.excel-btn',function(){
    var form = $(this).parents('form')[0];
    var act = $(form).attr('action');
    $(form).attr('action','$exportUrl');
    $(form).submit();
    $(form).attr('action',act);
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>