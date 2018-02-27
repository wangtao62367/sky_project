<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use backend\models\PublishCate;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a></li>
        <li><a href="<?php echo $url?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	
	<li><label>课表主题</label>
    <?php echo Html::activeTextInput($model, 'title',['class'=>'dfinput'])?>
    </li>
	
	<li><label>授课班级<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'gradeClassId',['class'=>'dfinput'])?>
    <?php echo Html::activeTextInput($model, 'gradeClass',['class'=>'dfinput ajaxSearch gradeClass','placeholder'=>'输入搜索授课班级'])?><i>授课班级不能为空</i>
    <div class="searchresult" style="display: none"> </div>
    </li>
    
    <li><label>是否发布<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'publishCode', PublishCate::$publishTimeArr,['class'=>'sky-select','id'=>'isPublish'])?>
    	</div>
    </li>
    
    <li class="publishTimeByUser" <?php echo $model->isPublish === 'userDefined' ? 'style="display:block"' : 'style="display:none"'; ?>><label>发布时间<b>*</b></label><?php echo Html::activeTextInput($model, 'publishTime',['class'=>'dfinput','style'=>'width:308px;','id'=>"publishTime"])?><i></i></li>
    
    <li><label>发布结束时间</label>
    	<?php echo Html::activeTextInput($model, 'publishEndTime',['id'=>'publishEndTime','class'=>'dfinput','style'=>'width:308px;','placeholder'=>'发布结束时间'])?>
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
CSS;
$getTeachers = Url::to(['teacher/ajax-teachers']);
$getCurriculums = Url::to(['curriculum/ajax-curriculums']);
$getPlaces = Url::to(['teachplace/ajax-places']);
$getGradeClass = Url::to(['gradeclass/ajax-classes']);
$js = <<<JS
$(document).on('click','.searchresult p',function(){
    console.log(23);
    var id = $(this).data('id');
    var text = $(this).data('text');
    $(this).parents('li').find('input[type="text"]').val(text);
    $(this).parents('li').find('input[type="hidden"]').val(id);
    $(this).parent('.searchresult').hide();
});

$(document).on('focus','.ajaxSearch',function(){
    var url = getInputAjaxtUrl(this);
    ajacGetSearch(url,'',this);
    $(this).parents('li').find('.searchresult').show();
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
    if(!res) return;
    var resultHtml = '';
    for(var i = 0;i < res.length;i++){
        resultHtml += '<p data-id="'+res[i].id+'" data-text="'+res[i].text+'">'+res[i].text+'</p>';
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





var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
$('.lessonDate').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
$('.lessonStartTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('.lessonEndTime').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});

$(document).on('change','#isPublish',function(){
    var val = $(this).val();
    if(val == 'userDefined'){
        $('.publishTimeByUser').show();
    }else{
        $('.publishTimeByUser').hide();
    }
})

//时间选择框
$('#publishTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      minDate : now,
      minTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

$('#publishEndTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      minDate : now,
      minTime : now,
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