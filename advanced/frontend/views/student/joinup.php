<?php


use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\models\Student;

$this->title = '我要报名-'.$gradeClass->className;

if(Yii::$app->session->hasFlash('error')){
    $error = Yii::$app->session->getFlash('error');
}

$nations = Yii::$app->params['nations'];

?>
<div class="step-box">
	<ul>
		<li>确认/修改个人信息</li>
		<li>填写报名信息</li>
	</ul>
</div>
<div class="form-box">
	<?php echo Html::beginForm('','post',['id'=>'myform','enctype'=>"multipart/form-data"]);?>
	<div class="field">
		<label class="field-title">报名班级：</label>
		<?php echo Html::activeHiddenInput($model,'gradeClassId');?>
		<?php echo Html::activeHiddenInput($model,'gradeClass');?>
		<p class="bm-gradeclass"><?php echo $gradeClass->className;?></p>
	</div>
	<div class="field field-avater">
		<label  class="field-title">头像：</label>
		<?php echo Html::activeHiddenInput($model,'avater');?>
		<?php echo Html::fileInput('avater',null,['style'=>'display:none','id'=>'avater','accept'=>"image/png, image/jpeg,image/jpg"])?>
		<a href="javascript:;" class="btn-select-avater">选择头像</a><span id="selected_avater"></span>
		<div class="avater-box">
			<?php if($model->avater):?>
			<img src="<?php echo $model->avater;?>"/>
			<?php endif;?>
		</div>
		<p class="form-error"></p>
	</div>
	
	<div class="field">
		<label  class="field-title">姓名：</label>
		<?php echo Html::activeTextInput($model, 'trueName',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['trueName'])){
			         echo $error['trueName'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">性别：</label>
		<?php echo Html::activeRadioList($model, 'sex',['1'=>'男','2'=>'女'],['class'=>'field-radio']);?>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['sex'])){
			         echo $error['sex'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">名族：</label>
		<?php echo Html::activeDropDownList($model, 'nationCode',$nations,['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['nationCode'])){
			         echo $error['nationCode'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">出生年月：</label>
		<?php echo Html::activeTextInput($model, 'birthday',['class'=>'text birthday']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['birthday'])){
			         echo $error['birthday'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">身份证号：</label>
		<?php echo Html::activeTextInput($model, 'IDnumber',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['IDnumber'])){
			         echo $error['IDnumber'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">政治面貌：</label>
		<?php echo Html::activeDropDownList($model, 'politicalStatusCode',Student::$politicalStatusArr,['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['politicalStatus'])){
			         echo $error['politicalStatus'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">联系电话：</label>
		<?php echo Html::activeTextInput($model, 'phone',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['phone'])){
			         echo $error['phone'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">现居城市：</label>
		<?php echo Html::activeTextInput($model, 'city',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['city'])){
			         echo $error['city'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">详细地址：</label>
		<?php echo Html::activeTextInput($model, 'address',['class'=>'text']);?>
	</div>
	
	<div class="field">
		<label  class="field-title">毕业学校：</label>
		<?php echo Html::activeTextInput($model, 'graduationSchool',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['graduationSchool'])){
			         echo $error['graduationSchool'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">毕业专业：</label>
		<?php echo Html::activeTextInput($model, 'graduationMajor',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['graduationMajor'])){
			         echo $error['graduationMajor'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">毕业学历：</label>
		<?php echo Html::activeDropDownList($model, 'eduationCode',Student::$eduationArr,['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['eduation'])){
			         echo $error['eduation'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">工作年限：</label>
		<?php echo Html::activeInput('number',$model, 'workYear',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['workYear'])){
			         echo $error['workYear'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">现工作单位：</label>
		<?php echo Html::activeTextInput($model, 'company',['class'=>'text']);?><i>*</i>
		<p class="form-error">
			<?php 
			     if(isset($error) && isset($error['company'])){
			         echo $error['company'][0];
			     }
			?>
		</p>
	</div>
	
	<div class="field">
		<label  class="field-title">工作职称：</label>
		<?php echo Html::activeTextInput($model, 'positionalTitles',['class'=>'text']);?>
	</div>
	
	<div class="field field-textarea">
		<label  class="field-title">个人介绍：</label>
		<?php echo Html::activeTextarea($model, 'selfIntruduce')?>
	</div>
	
	<div class="field field-btn">
		<button type="submit" class="btn btn-next">确认保存</button>
		<button type="button" class="btn btn-back">返回</button>
	</div>
	<?php echo Html::endForm();?>
	<div class="form-warning">
		<h2>提示信息</h2>
		<ul>
			<li>1、确认个人的基本信息正确并且有效</li>
			<li>2、带 <i>*</i> 的信息必须填写</li>
			<li>3、头像图片大小不能超过50KB，图片格式只能是 jpg、png或jpeg；建议图片大小为： 宽120像素 * 高120 像素</li>
			<li>4、姓名中间请不要输入空格,填写后不能修改！<a>如姓名中含有生僻字或“·”，参见姓名中如何输入生僻字</a></li>
			<li>5、身份证号填写以后不得自行修改</li>
		</ul>
	</div>
</div>
<?php 
$css = <<<CSS
.field .bm-gradeclass{
    display:inline-block;
    width: 400px;
    color: gray;
    border: 1px solid lightgray;
    padding-left: 5px;
    height: 30px;
    line-height: 30px;
}

CSS;
AppAsset::addCss($this, '/front/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/front/js/jquery.datetimepicker.full.js');
$js = <<<JS
$('.btn-back').click(function(){
    history.go(-1);
})
//选择头像
$(document).on('click','.btn-select-avater',function(){
    $("#avater").click();
})
$("#avater").change(function(){
    var _error = $(this).parent().find(".form-error");
    _error.empty();
    var file = this.files && this.files[0];
    var maxSize = 50 * 1025;//50kb
    var ext = ['image/jpeg','image/png','image/jpg']; 
    if(file.size > maxSize){
        _error.text("所选图片大小不能超过50KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        _error.text("所选图片格式只能是jpg、png或jpeg");return;
    }
	$("#selected_avater").text(file.name);
})

$(document).on('input propertychange','.field input,.field textarea',function(){
    var _error = $(this).parent().find(".form-error");
    _error.empty();
})
//时间
var now = new Date();
var yearStart = now.getFullYear() - 120;
var yearEnd = now.getFullYear();
$.datetimepicker.setLocale('ch');
$('.birthday').datetimepicker({
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
JS;

AppAsset::addCss($this, '/front/css/wybm.css');
$this->registerJs($js);
$this->registerCss($css);
?>