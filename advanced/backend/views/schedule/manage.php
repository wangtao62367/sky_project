<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['schedule/manage']),'get');?>
	<ul class="seachform">
		<li><label>授课班级</label><?php echo Html::activeTextInput($model, 'search[gradeClass]',['class'=>'scinput'])?></li>
        <li><label>课程名称</label><?php echo Html::activeTextInput($model, 'search[curriculumText]',['class'=>'scinput'])?></li>
        <li><label>授课教师</label><?php echo Html::activeTextInput($model, 'search[teacherName]',['class'=>'scinput'])?></li>
        <li><label>授课地点</label><?php echo Html::activeTextInput($model, 'search[teachPlace]',['class'=>'scinput'])?></li>
        <li>
        	<label>授课日期</label>
        	<?php echo Html::activeTextInput($model, 'search[startTime]',['class'=>'scinput startTime','placeholder'=>'开始日期'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[endTime]',['class'=>'scinput endTime','placeholder'=>'结束日期'])?>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['schedule/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        <li><a href="javascript:;" class="excel-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" value="" /></th>
            <th>授课班级</th>
            <th>课程名称</th>
            <th>上课时间</th>
            <th>授课教师</th>
            <th>授课地点</th>
            <th>发布主题</th>
            <th>是否发布</th>
            <th>发布时间</th>
            <th>发布结束时间</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" type="checkbox" class="item" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['gradeClass'];?></td>
            <td><?php echo $val['curriculumText'];?></td>
            <td><?php echo $val['lessonDate'] . ' ' . $val['lessonStartTime'] . '~' . $val['lessonEndTime'];?></td>
            <td><?php echo $val['teacherName'];?></td>
            <td><?php echo $val['teachPlace'];?></td>
            <td><?php echo $val['publishTitle'];?></td>
            <td><?php echo $val['isPublish'] == 1 ? '已发布' : '未发布';?></td>
            <td><?php echo MyHelper::timestampToDate($val['publishTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['publishEndTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['schedule/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>    
            <a href="javascript:;" data-url="<?php echo Url::to(['schedule/publish','id'=>$val['id']]);?>" class="tablelink publishBtn">发布</a>    
            <a href="<?php echo Url::to(['schedule/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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



<!-- 发布框 
<div class="modal"></div>
<div class="tip " style="display: block;">	
	<div class="tiptop"><span>发布课表</span><a></a></div>  
	<?php echo Html::beginForm();?>	
	<div class="tipinfo">       
 		<ul class="forminfo">
			<li><label>发布标题<b>*</b></label>
				<?php echo Html::activeTextInput($model, 'publishTitle',['class'=>'dfinput','style'=>'width:308px;'])?>
			</li>
			<li><label>发布时间<b>*</b></label><?php echo Html::activeTextInput($model, 'publishTime',['class'=>'dfinput','style'=>'width:308px;','id'=>"publishTime"])?><i></i></li>

            <li><label>发布结束时间<b>*</b></label>
            	<?php echo Html::activeTextInput($model, 'publishEndTime',['id'=>'publishEndTime','class'=>'dfinput','style'=>'width:308px;','placeholder'=>'发布结束时间'])?>
            </li>
 		</ul>
	 </div>    
	 <div class="tipbtn">      
	   <input name="" type="button" class="sure" value="确定">&nbsp;      
	     <input name="" type="button" class="cancel" value="取消">   
	  </div>
	  <?php echo Html::endForm();?>
</div>
-->
<?php 
$css = <<<CSS
.tip {
   height: 320px;
}
.tipinfo {
    padding-top: 20px;
    margin-left: 20px;
    height: 200px;
}
.forminfo li label {
    width: 86px;
    line-height: 34px;
    display: block;
    float: left;
    text-align: right;
    padding-right: 10px;
}
.tipbtn {
    margin-top: 0px;
    margin-left: 125px;
}
.xdsoft_datetimepicker{z-index:9999999;}
CSS;
$batchDelUrl = Url::to(['schedule/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['schedule/export']);
$js = <<<JS
//快速发布
$(document).on('click','.publishBtn',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        if(res){
            $(document).find('body').append(res);
        }
    })
})
//批量删除
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
var yearEnd = now.getFullYear() + 1;
var yearStart = yearEnd - 10;
var maxDate = now.setFullYear(yearEnd);
$.datetimepicker.setLocale('ch');
$('.startTime').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:false    //开启选择今天按钮
});

$('.endTime').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
//导出
$(document).on('click','.excel-btn',function(){
    var form = $(this).parents('form')[0];
    $(form).attr('action','$exportUrl');
    $(form).submit();
});

JS;
$this->registerJs($js);
$this->registerCss($css);
?>