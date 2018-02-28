<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Student;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户系统</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员管理</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['student/manage']),'get');?>
	<ul class="seachform">
        <li><label>学员姓名</label><?php echo Html::activeTextInput($model, 'search[trueName]',['class'=>'scinput'])?></li>
        
        <li><label>所在班级</label><?php echo Html::activeTextInput($model, 'search[gradeClass]',['class'=>'scinput'])?></li> 
        <li>
        	<label>报名时间</label>
        	<?php echo Html::activeTextInput($model, 'search[startTime]',['class'=>'scinput startTime','placeholder'=>'开始时间'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[endTime]',['class'=>'scinput endTime','placeholder'=>'结束时间'])?>
        </li>
        
        <li><label>学员性别</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[sex]', ['1'=>'男','2'=>'女'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li><label>学员名族</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[nationCode]', Yii::$app->params['nations'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li><label>是否优秀学员</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isBest]', ['1'=>'是','0'=>'否'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <li><a href="<?php echo Url::to(['statistics/student'])?>" class="export-btn">统计</a></li>
        <li><a href="javascript:;" class="excel-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>学员姓名</th>
            <th>所在班级</th>
            <th>联系电话</th>
            <th>性别</th>
            <th>名族</th>
            <th>职称</th>
            <th>工作单位</th>
            <th>报名时间</th>
            <th>优秀学员</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['student']['trueName'];?></td>
            <td><?php echo $val['gradeClass'];?></td>
            <td><?php echo $val['student']['phone'];?></td>
            <td><?php echo $val['student']['sex'] == 1 ? '男':'女';?></td>
            <td><?php echo $val['student']['nation'];?></td>
            <td><?php echo $val['student']['positionalTitles'];?></td>
            <td><?php echo $val['student']['company'];?></td>
            
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo $val['student']['isBest'] == 1 ? '是':'否';?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['student/info','id'=>$val['id']]);?>" class="tablelink">查看</a> 
            <?php if($val['student']['isBest'] == 0):?> 
            <a href="<?php echo Url::to(['student/set-best','id'=>$val['student']['id']]);?>" class="tablelink">加入优秀学员</a>
            <?php else:?>    
            <a href="<?php echo Url::to(['student/edit-best','id'=>$val['student']['id']]);?>" class="tablelink">修改优秀学员</a>
            <?php endif;?>
            <a href="<?php echo Url::to(['student/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['student/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['student/export']);
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
var yearEnd = now.getFullYear() + 1;
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
    $(form).attr('action','$exportUrl');
    $(form).submit();
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>