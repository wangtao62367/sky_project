<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['gradeclass/manage'])?>">班级管理</a></li>
        <li><a href="<?php echo $url?>">制作课表</a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span>制作课表</span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	<li><label>授课班级<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'gradeClassId',['class'=>'dfinput','value'=>$classId,'readonly'=>true])?>
    <?php echo Html::activeTextInput($model, 'gradeClass',['class'=>'dfinput ajaxSearch gradeClass','readonly'=>true,'value'=>$className])?>
    <div class="searchresult" style="display: none"> </div>
    </li>
	
    <li><label>课程名称<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'curriculumId',['class'=>'dfinput'])?>
    <?php echo Html::activeTextInput($model, 'curriculumText',['class'=>'dfinput ajaxSearch curriculumText','placeholder'=>'输入搜索课程名称'])?><i>课程不能为空</i>
    <div class="searchresult">
    </div>
    </li>
    <li><label>授课日期<b>*</b></label>
    	<?php echo Html::activeTextInput($model, 'lessonDate',['class'=>'dfinput lessonDate','style'=>'width:240px;','placeholder'=>'选择授课日期'])?>
    </li>
    <li><label>授课时段<b>*</b></label>
    	<?php echo Html::activeTextInput($model, 'lessonStartTime',['class'=>'dfinput lessonStartTime','style'=>'width:74px;','placeholder'=>'开始时间'])?> - 
    	<?php echo Html::activeTextInput($model, 'lessonEndTime',['class'=>'dfinput lessonEndTime','style'=>'width:74px;','placeholder'=>'结束时间'])?>
    </li>
    <li><label>授课教师<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'teacherId',['class'=>'dfinput'])?>
    <?php echo Html::activeTextInput($model, 'teacherName',['class'=>'dfinput ajaxSearch teacherName','placeholder'=>'输入搜索课程授课教师'])?><i>授课教师不能为空</i>
    <div class="searchresult" style="display: none"> </div>
    </li>
    
    <li><label>授课地点<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'teachPlaceId',['class'=>'dfinput'])?>
    <?php echo Html::activeTextInput($model, 'teachPlace',['class'=>'dfinput ajaxSearch teachPlace','placeholder'=>'输入搜索授课地点'])?><i>授课地点不能为空</i>
    <div class="searchresult" style="display: none"> </div>
    </li>
    
    
    
    <li><label>备&nbsp;&nbsp;注</label><?php echo Html::activeTextarea($model, 'marks',['class'=>'textinput'])?><i></i></li>
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
span.search-no-data{
    text-align: center;
    height: 50px;
    line-height: 50px;
}
span.search-no-data a{color:red;}
CSS;
$getTeachers = Url::to(['teacher/ajax-teachers']);
$getCurriculums = Url::to(['curriculum/ajax-curriculums']);
$getPlaces = Url::to(['teachplace/ajax-places']);
$getGradeClass = Url::to(['gradeclass/ajax-classes']);

$addTeacher = Url::to(['teacher/add']);
$addCurriculum = Url::to(['curriculum/add']);
$addPlace = Url::to(['teachplace/add']);
$addGradeClass = Url::to(['gradeclass/add']);
$js = <<<JS
$(document).on('click','.searchresult p',function(){
    var id = $(this).data('id');
    var text = $(this).data('text');
    $(this).parents('li').find('input[type="text"]').val(text);
    $(this).parents('li').find('input[type="hidden"]').val(id);
    $(this).parent('.searchresult').hide();
});

$(document).on('focus','.ajaxSearch',function(){
    var url = getInputAjaxtUrl(this);
	if(!$(this).val()){
   		ajacGetSearch(url,'',this);
    	$(this).parents('li').find('.searchresult').show();
	}
});

// $(document).on('focusout','input[type="text"]',function(){
//     $(this).parents('li').find('.searchresult').hide();
// });

$(document).on('input propertychange','.ajaxSearch',throttle(getCurriculum,500,1000));

function getCurriculum(el){
    var keywords = $(el.target).val();
    var url = getInputAjaxtUrl(el.target);
    ajacGetSearch(url,keywords,el.target);
}

function getInputAjaxtUrl(_this){
    var url = '';
    if($(_this).hasClass('teacherName')){
        url = '$getTeachers';
    }else if($(_this).hasClass('curriculumText')){
       url = '$getCurriculums';
    }else if($(_this).hasClass('teachPlace')){
        url = '$getPlaces';
    }else if($(_this).hasClass('gradeClass')){
       url = '$getGradeClass';
    }
    return url;
}

function ajacGetSearch(url,keywords,_this){
    $.get(url,{keywords:keywords},function(res){
        showSearchResult(_this,res,keywords);
    })
}


function showSearchResult(_this,res){
    var resultHtml = '';
	if(res.length == 0){
		url = '';
		if($(_this).hasClass('teacherName')){
			url = '$addTeacher';
	    }else if($(_this).hasClass('curriculumText')){
	    	url = '$addCurriculum';
	    }else if($(_this).hasClass('teachPlace')){
	    	url = '$addPlace';
	    }else if($(_this).hasClass('gradeClass')){
	       url = '$addGradeClass';
	    }
		resultHtml = '<span class="search-no-data">没有数据，<a href="'+url+'">立即去添加?</a><span>';
	} else{
	    for(var i = 0;i < res.length;i++){
	        resultHtml += '<p data-id="'+res[i].id+'" data-text="'+res[i].text+'">'+res[i].text+'</p>';
	    }
	}
    $(_this).parents('li').find('.searchresult').empty();
    $(_this).parents('li').find('.searchresult').append(resultHtml);
}

//节流函数
function throttle(func, wait, mustRun) {
    var timeout,
        startTime = new Date();

    return function() {
        var context = this,
            args = arguments,
            curTime = new Date();

        clearTimeout(timeout);
        // 如果达到了规定的触发时间间隔，触发 handler
        if(curTime - startTime >= mustRun){
            func.apply(context,args);
            startTime = curTime;
        // 没达到触发间隔，重新设定定时器
        }else{
            timeout = setTimeout(function(){
                func.apply(context,args);
            }, wait);
        }
    };
};


// function debounce(func,wait,immediate) {
//     var timeout , context, args;
//     return function() {
//         context = this;
//         args = arguments;
//         if(timeout) clearTimeout(timeout);
//         if(immediate){
//             var callNow = !timeout;
//             timeout = setTimeout(function(){
//                 timeout = null;
//             },wait);
//             if(callNow){
//                 func.apply(context);
//             }  
//         }else {
//             timeout = setTimeout(function(){
//                 func.apply(context);
//             },wait);
//         }
          
//     }
// };
var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
$('.lessonDate').datetimepicker({
      //lang:"zh", //语言选择中文 注：旧版本 新版方法：$.datetimepicker.setLocale('ch');
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
	  minDate : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
$('.lessonStartTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	minTime:now,
	step:5
});
$('.lessonEndTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	minTime:now,
	step:5
});
JS;
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>