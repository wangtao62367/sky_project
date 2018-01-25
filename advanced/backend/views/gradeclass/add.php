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
        <li><a href="<?php echo $url?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>班级名称<b>*</b></label><?php echo Html::activeTextInput($model, 'className',['class'=>'dfinput'])?><i>班级名称长度为2-20个字</i></li>
    <li><label>班级人数<b>*</b></label><?php echo Html::activeTextInput($model, 'classSize',['class'=>'dfinput'])?><i>班级人数5-60人</i></li>
    <li><label>报名时间<b>*</b></label><?php echo Html::activeTextInput($model, 'joinStartDate',['class'=>'dfinput joinStartDate','style'=>'width:240px;','placeholder'=>'开始时间'])?> - 
    <?php echo Html::activeTextInput($model, 'joinEndDate',['class'=>'dfinput joinEndDate','style'=>'width:240px;','placeholder'=>'开始时间'])?>
    </li>
    
    <li><label>开班时间<b>*</b></label>
    <?php echo Html::activeTextInput($model, 'openClassTime',['class'=>'dfinput openClassTime','style'=>'width:240px;','placeholder'=>'开班时间'])?>
    </li>
    <li><label>教务员姓名<b>*</b></label><?php echo Html::activeTextInput($model, 'eduAdmin',['class'=>'dfinput'])?><i>教务员姓名不能为空</i></li>
    <li><label>教务员电话<b>*</b></label><?php echo Html::activeInput('telephone',$model, 'eduAdminPhone',['class'=>'dfinput'])?><i>教务员手机号不能为空</i></li>
    
    <li><label>多媒体管理员<b>*</b></label><?php echo Html::activeTextInput($model, 'mediaAdmin',['class'=>'dfinput'])?><i>多媒体管理员姓名不能为空</i></li>
    <li><label>多媒体管理员电话<b>*</b></label><?php echo Html::activeInput('telephone',$model, 'mediaAdminPhone',['class'=>'dfinput'])?><i>多媒体管理员手机号不能为空</i></li>
    
    <li><label>开班时出席领导<b>*</b></label><?php echo Html::activeTextInput($model, 'openClassLeader',['class'=>'dfinput'])?><i>开班时出席领导不能为空</i></li>
    <li><label>结业时出席领导<b>*</b></label><?php echo Html::activeTextInput($model, 'closeClassLeader',['class'=>'dfinput'])?><i>结业时出席领导不能为空</i></li>
    
    <li><label>本院教师任课节数<b>*</b></label><?php echo Html::activeInput('number',$model, 'currentTeachs',['class'=>'dfinput'])?><i>本院教师任课节数不能为空</i></li>
    <li><label>邀约教师任课节数<b>*</b></label><?php echo Html::activeInput('number',$model, 'invitTeachs',['class'=>'dfinput'])?><i>邀约教师任课节数不能为空</i></li>
    <li><label>备&nbsp;&nbsp;注</label><?php echo Html::activeTextarea($model, 'remarks',['class'=>'textinput'])?><i></i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$js = <<<JS
var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
$('.joinStartDate').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

$('.joinEndDate').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

$('.openClassTime').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      yearStart: yearStart,//设置最小年份
      yearEnd:yearEnd,     //设置最大年份
      todayButton:true     //开启选择今天按钮
});
JS;
$css = <<<CSS
.forminfo li label {
    width: 115px;
    line-height: 34px;
    display: block;
    float: left;
}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>