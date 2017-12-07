<?php

use backend\assets\AppAsset;
use yii\helpers\Html; 
$this->title="添加试题";
?>

<p style="color: red;font-size:14px">
	<?php if(Yii::$app->session->hasFlash('error')){ echo Yii::$app->session->getFlash('error');} ?>
	<?php if(Yii::$app->session->hasFlash('success')){ echo Yii::$app->session->getFlash('success');} ?>
</p>
<?php echo Html::beginForm();?>
<div class="form-group form-subject">
	<div class="form-lable"><?php echo Html::label('试题标题：','title');?></div>
	<div class="form-input">
		<?php echo Html::activeTextarea($model, 'title',[
    	    'placeholder'=>'请填写测评试题标题(3-100字)',
		    'autocomplete'=>'off',
    	    'data-sy-required'=>true,
    	    'data-sy-required-message'=>'测评试题标题不能为空'
    	]);?>
	</div>
</div>

<div class="form-group">
	<div class="form-lable"><?php echo Html::label('试题选项：','opts')?></div>
	<div class="form-input questoptions">

		<?php $optCount = 'A';for ($i = 0;$i < count($model->opts);$i++ ){?>
        	<p>
        		<?php echo Html::activeTextInput($model, "opts[$i][opt]",['placeholder'=>'选项'.$optCount]);?>
        		<?php if($i>=2){?>
        			<a class="delete-btn" href="javascript:;" title="删除"><i>✖</i></a>
        		<?php }?>
        	</p>
    	<?php $optCount++ ;}?>
    	<a id="addoptions"  href="javascript:;"><i>✚</i>添加选项</a>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('试题类型：','cate')?></div>
	<div class="form-input cate">
		<?php echo Html::activeDropDownList($model, 'cate', $questCate,['style'=>'width:100px'])?>
	</div>
</div>


<div class="form-group">
	<div class="form-lable"><?php echo Html::label('正确答案：','answerOpt')?></div>
	<div class="form-input answerOpt">
		<?php echo Html::activeCheckboxList($model, 'answerOpt',['A'=>'A']);?>
	</div>
</div>

<div class="form-group">
	<div class="form-lable"><?php echo Html::label('试题分数：','score')?></div>
	<div class="form-input">
		<?php 
		echo Html::activeTextInput($model, 'score',[
		    'placeholder'=>'请输入试题分数',
		    'autocomplete'=>'off'
		]);
        ?>
	</div>
</div>

<div class="form-group form-btn">
	<?php echo Html::submitInput('确认保存',['class'=>'btn btn-primary']);?>
	<?php echo Html::resetInput('清空重置',['class'=>'btn'])?>
</div>


<?php 
    AppAsset::addCss($this, 'admin/css/form.css');
    $answerOpt = json_encode($model->answerOpt);
    $js = <<<JS
$(document).on('click','.delete-btn',function(e){
    var parent = $(this).parent().parent('div');
    $(this).parent('p').remove();
    parent.find('p').each(function(index,element){
        var option =  String.fromCharCode(index +65);
        $(this).find('input').attr('placeholder','选项'+option);
        $(this).find('input').attr('name',"Question[opts]["+index+"][opt]");
        $(this).find('input').attr('id',"question-opts-"+index+"-opt");
    })
    createAnswerOpt();
});

$('#addoptions').click(function(ev){
    var optionCount = $('.questoptions').find('p').length;
    var option =  String.fromCharCode(optionCount+65);
    var optionHtml = '<p><input type="text" id="question-opts-'+optionCount+'-opt" name="Question[opts]['+optionCount+'][opt]" placeholder="选项'+option+'"><a class="delete-btn" href="javascript:;" title="删除"><i>✖</i></a></p>';
    $(this).parent('div').find('p:last').after(optionHtml);
    createAnswerOpt();
});

$('#question-answeropt').on('click','input[type=checkbox]',function(){
    console.log($('#question-cate').val());
    if($(this).prop('checked') && $('#question-cate').val() == 'unknow'){
        $(this).prop('checked',false);
        showError('请先选择试题类型','','');
        return;
    }
    var checked = $('#question-answeropt').find('input[type=checkbox]:checked').length;
    if($(this).prop('checked') && $('#question-cate').val() == 'radio' && checked > 1){
        showError('单项选择只能有一个正确选项答案','','');
        $(this).prop('checked',false);
        return;
    }
});

$('#question-cate').change(function(ev){
    if($(this).val() != 'multi'){
        $('#question-answeropt').find('input[type=checkbox]:checked').prop('checked',false);
    }
});
var answerOpt = $answerOpt;
function createAnswerOpt(){
    var optionCount = $('.questoptions').find('p').length;
    var questionAnsweropt = $('#question-answeropt');
    var lables = '';
    for (var i = 0 ; i < optionCount ; i++){
        var option =  String.fromCharCode(i+65);
        if($.inArray(option,answerOpt) !== -1){
            lables += '<label><input type="checkbox" checked ="true" name="Question[answerOpt][]" value="'+option+'">'+option+'</label>';
        }else{
            lables += '<label><input type="checkbox" name="Question[answerOpt][]" value="'+option+'">'+option+'</label>';
        }
    }
    questionAnsweropt.empty().append(lables);
}
createAnswerOpt();
JS;
$css = <<<CSS
input[type=checkbox] {
width: 16px;
height: 16px;
margin-top: 3px;
display: inline-block;
}
#question-answeropt label{margin-right:10px;}
CSS;
    $this->registerJs($js);
    $this->registerCss($css);
?>
