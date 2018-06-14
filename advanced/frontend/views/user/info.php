<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\TestPaper;
use yii\helpers\Html;
use common\models\Profile;

$this->title = '个人信息';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="<?php echo Url::to(['user/center']);?>">我的报名</a></li>
		
		<li><a  class="UnitedFront">我的信息</a></li>
		
		<li><a href="<?php echo Url::to(['user/edit-pwd']);?>" >修改密码</a></li>

		<li><a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wybm']);?>">我要报名</a></li>
	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $this->title;?></h2>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<?php echo Html::beginForm('','post',['id'=>'myform','enctype'=>"multipart/form-data"]);?>
			
			<div class="field">
				<label class="title title-avater">头像：</label>
				<div class="avater-box">
					<?php echo Html::activeHiddenInput($model, 'avater');?>
					<?php if(!empty($model->avater)):?>
					<div class="img-box">
						<img alt="头像" src="<?php echo $model->avater;?>" width="120px" height="120px">
					</div>
					<?php endif;?>
					<div class="img-select-btn">
						<?php echo  Html::fileInput('avater',null,['style'=>'display:none','id'=>"avater",'accept'=>"image/png, image/jpeg,image/jpg"])?>
						<a href="javascript:;" id="selectimgbtn">选择图片</a> <span id="selectedimg"></span>
						<span>（只支持.png、.jpeg和.jpg格式的图片）</span>
						<p class="form-error"></p>
					</div>
				</div>
			</div>
			
			<div class="field">
				<div class="field-left field-truename">
					<label class="title">姓名：</label>
					<?php echo Html::activeTextInput($model, 'trueName',['class'=>'txt'])?>
				</div>
				<div class="field-left field-sex">
					<label class="title">姓别：</label>
					<?php echo Html::activeRadioList($model, 'sex', ['1'=>'男','2'=>'女'],['class'=>'field-radio'])?>
				</div>
			</div>
			
			<div class="field">
				<div class="field-left field-nation">
					<label class="title">民族：</label>
					<?php echo Html::activeDropDownList($model, 'nationCode', Yii::$app->params['nations'],['class'=>'dropselect'])?>
				</div>
				<div class="field-left field-birthday">
					<label class="title">生日：</label>
					<?php echo Html::activeTextInput($model, 'birthday',['class'=>'txt birthday'])?>
				</div>
			</div>
			
			<div class="field">
				<div class="field-left field-politicalStatus">
					<label class="title">政治面貌：</label>
					<?php echo Html::activeDropDownList($model, 'politicalStatusCode', Profile::$politicalStatusArr,['class'=>'dropselect'])?>
				</div>
				<div class="field-left field-IDnumber">
					<label class="title">身份证号：</label>
					<?php echo Html::activeTextInput($model, 'IDnumber',['class'=>'txt'])?>
				</div>
			</div>
			
			<div class="field">
				<label class="title">现居地址：</label>
				<?php echo Html::activeTextInput($model, 'city',['class'=>'txt'])?>  <?php echo Html::activeTextInput($model, 'address',['class'=>'address'])?>
			</div>
			
			<div class="field">
				<label class="title">工作单位：</label>
				<?php echo Html::activeTextInput($model, 'company',['class'=>'txt'])?>
			</div>
			
			<div class="field">
				<div class="field-left field-workyear">
					<label class="title">工作年限：</label>
					<?php echo Html::activeInput('number',$model, 'workYear',['class'=>'txt','min'=>0,'max'=>80])?>
				</div>
				<div class="field-left field-positionalTitles">
					<label class="title">工作职称：</label>
					<?php echo Html::activeTextInput($model, 'positionalTitles',['class'=>'txt'])?> 
				</div>
			</div>
			
			<div class="field">
				<label class="title">毕业学校：</label>
				<?php echo Html::activeTextInput($model, 'graduationSchool',['class'=>'txt'])?>  
			</div>
			
			<div class="field">
				<div class="field-left field-graduationMajor">
					<label class="title">毕业专业：</label>
					<?php echo Html::activeTextInput($model, 'graduationMajor',['class'=>'txt'])?>  
				</div>
				<div class="field-left field-eduation">
					<label class="title">学历：</label>
					<?php echo Html::activeDropDownList($model, 'eduationCode', Profile::$eduationArr,['class'=>'dropselect'])?>
				</div>
			</div>
			
			<div class="field">
				<label class="title"></label>
				<p class="form-error"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
				<input type="submit" value="修改保存" class="btn btn-submit"> 
			</div>
		
		<?php echo Html::endForm();?>
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
$css = <<<CSS

.field{
    margin-bottom:15px;
    position: relative;
    overflow: hidden;
}

.field .txt{width:220px;height:25px;padding-left:5px;}
.address{width:402px;height:25px;padding-left:5px;}
.dropselect{width: 229px;height:29px;padding-left:5px;}
.field label{display:inline-block;width:100px;text-align:right;}
.field-radio{display:inline-block;}
.field-radio label{text-align:left;}

.title-avater,.avater-box{display:inline-block;width:600px;height:140px;float:left}
.avater-box .img-box{float:left;width:120px;height:120px;border: 1px solid #333;border-style: dotted;border-radius: 5px;border: 1px solid #333;border-style: dotted;border-radius: 5px;margin-left: 5px;text-align:center;line-height:120px;}
.avater-box .img-select-btn{
    display: block;
    margin-left: 10px;
    float:left;
}

.avater-box .img-select-btn #selectimgbtn{
    display: inline-block;
    padding: 5px 10px;
    background: #eceaea;
    color: #000;
    border-radius: 5px;
}
.avater-box .img-select-btn #selectimgbtn:hover{background: #c1bcbc;}

.form-error{color:red;}

.field .btn{display:block;padding:5px 10px;background:#f11616;color:#fff;margin: 0 auto;margin-top:40px}
.field .btn-submit:hover{background:#c71010}

.field-left{
    float:left;
    margin-right:15px;
    width: 400px;
}

.section .content ._hr {
    margin-top: -15px;
}
CSS;
AppAsset::addCss($this, '/front/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/front/js/jquery.datetimepicker.full.js');
$uploadurl = Url::to(['/user/ajax-upload']);
$js = <<<JS
$(document).on('click','#selectimgbtn',function(){
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
	$("#selectedimg").empty().text(file.name);
    
    var formData = new FormData();
    formData.append('file',file);
    $('.img-box').empty().append('<img src="/front/img/loading.gif" />');
    common.uploadFile(formData,'$uploadurl',function(res){
        if(res.success){
            $('.img-box').empty().append('<img src="'+res.data+'" width="120px" height="120px"/>');
        }
    },function(err){
        console.log(err);
    });
});

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
$this->registerJs($js);
$this->registerCss($css);
?>