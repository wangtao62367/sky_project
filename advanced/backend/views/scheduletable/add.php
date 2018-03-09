<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use backend\models\PublishCate;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));

$this->title = $title.'-'.$schedule->title.'【'.$schedule->gradeClass.'】';
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a></li>
        <li><a href="<?php echo Url::to(['schedule/info','id'=>$schedule->id])?>">查看设置课表-<?php echo $schedule->title.'【'.$schedule->gradeClass.'】';?></a></li>
        <li><a href="<?php echo $url?>"><?php echo $this->title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $this->title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	
	<li><label>课程名称<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'curriculumText',['class'=>'dfinput','id'=>'curriculumText'])?>
    <div class="vocation">
		<?php echo Html::activeDropDownList($model, 'curriculumId', ArrayHelper::map($curriculumList, 'id', 'text'),['class'=>'sky-select','prompt'=>'请选择课程','id'=>'curriculumId','style'=>'width:347px'])?>
	</div>
    </li>
    <li><label>授课日期<b>*</b></label>
    	<?php echo Html::activeTextInput($model, 'lessonDate',['class'=>'dfinput lessonDate','style'=>'width:240px;','placeholder'=>'选择授课日期'])?>
    </li>
    <li><label>授课时段<b>*</b></label>
    	<?php echo Html::activeTextInput($model, 'lessonStartTime',['class'=>'dfinput lessonStartTime','style'=>'width:74px;','placeholder'=>'开始时间'])?> - 
    	<?php echo Html::activeTextInput($model, 'lessonEndTime',['class'=>'dfinput lessonEndTime','style'=>'width:74px;','placeholder'=>'结束时间'])?>
    	<i>结束时段必须大于开始时段</i>
    </li>
    
    <li><label>授课教师<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'teacherName',['class'=>'dfinput','id'=>'teacherName'])?>
    <div class="vocation">
		<?php echo Html::activeDropDownList($model, 'teacherId', empty($teachers)?[]:ArrayHelper::map($teachers, 'id', 'trueName'),['class'=>'sky-select','prompt'=>'请选择授课教师','id'=>'teacherId','style'=>'width:347px'])?>
		<i id="noteachers" style="color: red"></i><i>请先确定授课日期和时段，系统会自动得到当前时间空闲的授课教师</i>
	</div>
    </li>
    
    <li><label>授课地点<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'teachPlace',['class'=>'dfinput','id'=>'teachPlace'])?>
    <div class="vocation">
		<?php echo Html::activeDropDownList($model, 'teachPlaceId',empty($places)?[]:ArrayHelper::map($places, 'id', 'text'),['class'=>'sky-select','prompt'=>'请选择授课地点','id'=>'teachPlaceId','style'=>'width:347px'])?>
		<i>请先确定授课日期和时段，系统会自动得到当前时间空闲的授课地点</i>
	</div>
    </li>
	
	
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>
<?php
$css = <<<CSS
.searchresult{
    position: absolute;
    width: 345px;
    min-height: 50px;
    max-height: 100px;
    margin-left: 86px;
    border-top: 0px;
    border-left: solid 1px #a7b5bc;
    border-right: solid 1px #ced9df;
    border-bottom: solid 1px #ced9df;
    background: #fff;
    overflow: hidden;
    overflow-y: scroll;
    text-indent: 10px;
    display:none;
}
.searchresult p{
    padding : 5px 0px;
    cursor: pointer;
}
.searchresult p:hover{
    background:#e8e5e5;
}
.xdsoft_datetimepicker  .xdsoft_calendar td > div{
   padding-right:10px;
   padding-top: 5px
}
CSS;
$getTeachers = Url::to(['teacher/ajax-teachers']);
$getCurriculums = Url::to(['curriculum/ajax-curriculums']);
$getPlaces = Url::to(['teachplace/ajax-places']);
$getGradeClass = Url::to(['gradeclass/ajax-classes']);
$js = <<<JS
//选择课程
$("#curriculumId").change(function(){
    var text = $(this).find("option:selected").text();
    $("#curriculumText").val(text);
});
//选择教师
$("#teacherId").change(function(){
    var text = $(this).find("option:selected").text();
    $("#teacherName").val(text);
});
//选择地点
$("#teachPlaceId").change(function(){
    var text = $(this).find("option:selected").text();
    $("#teachPlace").val(text);
});


//时间选择框
var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
$('.lessonDate').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      minDate :now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true,    //开启选择今天按钮
      onSelectDate : function(){
          selectedDateTime();
      }
});
$('.lessonStartTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:10,
    onSelectTime : function(){
        selectedDateTime();
   }
});
$('.lessonEndTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:10,
    onSelectTime : function(){
        selectedDateTime();
    }
});
//确认授课时间时
function selectedDateTime(){
    var lessonStartTime = $('.lessonStartTime').val();
    var lessonEndTime = $('.lessonEndTime').val();
    var lessonDate = $('.lessonDate').val();
    if(lessonStartTime == '' || lessonEndTime == '' || lessonDate == ''){
        return false;
    }
    var start = new Date("2018/03/09 " + lessonStartTime).getTime() / 1000;  
    var end = new Date("2018/03/09 " +lessonEndTime).getTime() / 1000; 
    if(end < start){
        $('.lessonEndTime').val('');
        return false;
    }
    
    $.get('/scheduletable/teachers-places',{lessonDate:lessonDate,lessonStartTime:lessonStartTime,lessonEndTime:lessonEndTime},function(res){
        if(res){
            var teachers = res.teachers;
            var places = res.places;
            var teachersOpt = '';
            var placesOpt = '';
            for(var i = 0;i<teachers.length;i++){
                teachersOpt += '<option value="">请选择授课教师</option><option value="'+teachers[i].id+'">'+teachers[i].trueName+'</option>'
            }
            for(var i = 0;i<places.length;i++){
                placesOpt += '<option value="">请选择授课地点</option><option value="'+places[i].id+'">'+places[i].text+'</option>'
            }
            if(teachersOpt == ''){
                $("#noteachers").text('当前授课时间教师都很忙，没有授课教师');return false;
            }
            if(placesOpt == ''){
                $("#noplaces").text('当前授课时间没有可用的授课地点'); return false;
            }
            $('#teacherId').empty().append(teachersOpt);
            $('#teachPlaceId').empty().append(placesOpt);
        };
    })
}

JS;
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>