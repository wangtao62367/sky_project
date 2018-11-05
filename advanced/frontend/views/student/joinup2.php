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
<div class="form-warning">
	<h2>注意事项：</h2>
	<ul>
		<li>1、请确认个人的报名信息正确并且真实有效</li>
		<li>2、头像图片格式只能是 jpg、png或jpeg；建议图片大小为： 标准的2寸照片且不大于50KB</li>
		<li>3、姓名中间请不要输入空格,填写后不能修改！<a>如姓名中含有生僻字或“·”，参见姓名中如何输入生僻字</a></li>
	</ul>
</div>
<div class="form-box">
	<?php echo Html::beginForm('','post',['id'=>'myform','enctype'=>"multipart/form-data"]);?>
	<?php echo Html::activeHiddenInput($model, 'gradeClassId');?>
	<?php echo Html::activeHiddenInput($model, 'gradeClass');?>
		<table class="mytable" cellspacing="0" cellpadding="10px">
			<tr>
				<td class="title">姓名</td>
				<td>
					<?php echo Html::activeTextInput($model, 'trueName')?>
				</td>
				
				<td class="title">性别</td>
				<td>
					<?php echo Html::activeDropDownList($model, 'sex', ['1'=>'男','2'=>'女'],['autocomplete'=>'off'])?>
				</td>
				
				<td class="title">出生年月</td>
				<td>
					<?php echo Html::activeTextInput($model, 'birthday',['class'=>'timeselect','autocomplete'=>'off'])?>
				</td>
				
				<td rowspan="3">
					<?php echo Html::fileInput('avater',null,['style'=>'display:none','id'=>'avater'])?>
					<div class="avater-box" id="avater-upload">
						选择证件照
					</div>
					<p class="form-error"></p>
				</td>
			</tr>
			
			<tr>
				<td class="title">政治面貌</td>
				<td>
					<?php echo Html::activeTextInput($model, 'political')?>
				</td>
				
				<td class="title">民族</td>
				<td>
					<?php echo Html::activeDropDownList($model, 'nationCode', $nations)?>
				</td>
				
				<td class="title">健康状况</td>
				<td>
					<?php echo Html::activeTextInput($model, 'health')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">文化程度</td>
				<td>
					<?php echo Html::activeTextInput($model, 'eduDegree')?>
				</td>
				
				<td class="title">特长</td>
				<td colspan="3">
					<?php echo Html::activeTextInput($model, 'speciality')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">参加工作时间</td>
				<td>
					<?php echo Html::activeTextInput($model, 'dateToWork',['class'=>'timeselect','autocomplete'=>'off'])?>
				</td>
				
				<td class="title">参加党派时间</td>
				<td colspan="2">
					<?php echo Html::activeTextInput($model, 'dateToPolitical',['class'=>'timeselect','autocomplete'=>'off'])?>
				</td>
				
				<td class="title">级别</td>
				<td>
					<?php echo Html::activeTextInput($model, 'politicalGrade')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">工作单位</td>
				<td colspan="4">
					<?php echo Html::activeTextInput($model, 'workplace')?>
				</td>
				
				<td class="title">职务及职称</td>
				<td colspan="3">
					<?php echo Html::activeTextInput($model, 'workDuties')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">组织机构</td>
				<td colspan="3">
					<?php echo Html::activeTextInput($model, 'orgCode')?>
				</td>
				
				<td class="title">身份证号码</td>
				<td colspan="2">
					<?php echo Html::activeTextInput($model, 'IDnumber',['autocomplete'=>'off'])?>
				</td>
			</tr>
			
			<tr>
				<td class="title" rowspan="2">通讯地址</td>
				<td colspan="4" rowspan="2">
					<?php echo Html::activeTextarea($model, 'address',['style'=>'width:100%;height: 110px;'])?>
				</td>
				
				<td class="title">邮编</td>
				<td>
					<?php echo Html::activeTextInput($model, 'postcode')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">电话</td>
				<td>
					<?php echo Html::activeTextInput($model, 'phone',['autocomplete'=>'off'])?>
				</td>
			</tr>
			
			<tr>
				<td class="title">社会职务</td>
				<td colspan="3">
					<?php echo Html::activeTextInput($model, 'socialDuties')?>
				</td>
				
				<td class="title">党派职务</td>
				<td colspan="2">
					<?php echo Html::activeTextInput($model, 'politicalDuties')?>
				</td>
			</tr>
			
			<tr>
				<td class="title">简历</td>
				<td colspan="6">
					<?php echo Html::activeTextarea($model, 'introduction',['style'=>'width:100%;height:140px;'])?>
				</td>
			</tr>
			
			<tr>
				<td class="title">推荐单位</td>
				<td colspan="4">
					<?php echo Html::activeTextInput($model, 'recommend')?>
				</td>
				
				<td class="title">市州</td>
				<td >
					<?php echo Html::activeTextInput($model, 'citystate')?>
				</td>
			</tr>
			
			<tr>
				<td colspan="7" align="left" style="text-align: left;padding-left:20px;padding-top:10px;padding-bottom:10px;">
					<h2>注意：</h2>
					<p>以上信息必须保证完整，且真实有效；提交报名申请以后不能修改</p>
					<br/>
					<?php if(isset($error)):?>
					<?php foreach ($error as $k=>$err):?>
						<p class="error" id="<?php echo $k;?>"><?php echo $err[0]?></p>
					<?php endforeach;?>
					<?php endif;?>
					<?php echo Html::submitButton('确认保存',['class'=>'btn '])?>
				</td>
			</tr>
		</table>
	<?php echo Html::endForm();?>
</div>
<?php 
$css = <<<CSS
table.mytable {
    border-collapse: collapse;
    width:1170px;
    margin:0 auto;
}

table.mytable,table.mytable td,table.mytable th {
    border: 1px solid #333;
    text-align:left;
    padding-left:8px;
    box-sizing:border-box;
    height:60px;
    min-width:80px;
}
table.mytable td.title{text-align:center;}
table.mytable input,textarea{outline:none;border:none;box-sizing: border-box;min-width:200px;width:100%;height: 50px;}
table.mytable td select{height:40px;width:90px}
.form-box table .title{
    font-weight:700;
}
.avater-box{
    width:160px;
    height:240px;
    margin:0 auto;
    text-align:center;
    line-height:240px;
    border:1px solid #333;
    border-style: dotted;
    border-radius: 5px;
    cursor: pointer;
}
.form-error {
    text-align:center;
    color: red;
    padding-left: 0px; 
}
.error{color:red;}
CSS;
AppAsset::addCss($this, '/front/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/front/js/jquery.datetimepicker.full.js');
$js = <<<JS
$('.btn-back').click(function(){
    history.go(-1);
})
//选择头像
$(document).on('click','#avater-upload',function(){
    $("#avater").click();
})
$("#avater").change(function(){
    var _error = $(this).parent().find(".form-error");
    _error.empty();
    var file = this.files && this.files[0];
    var maxSize = 50 * 1025;//50kb
    var ext = ['image/jpeg','image/png','image/jpg']; 
    if(file.size > maxSize){
        _error.text("所选图片大小不能超过50KB");
        $("#avater-upload").text('选择证件照');
        return;
    }
    if($.inArray(file.type,ext) == -1){
        _error.text("所选图片格式只能是jpg、png或jpeg");
        $("#avater-upload").text('选择证件照');
        return;
    }
	//$("#selected_avater").text(file.name);
    var img = document.createElement("img")  
    img.src = window.URL.createObjectURL(file)  
    img.style.width = "120px";
    img.style.height = "120px";
    img.onload = function () {  
        window.URL.revokeObjectURL(this.src)  
    }  
    $("#avater-upload").empty().append(img);
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
$('.timeselect').datetimepicker({
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