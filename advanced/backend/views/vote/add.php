<?php 

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\Url;

$this->title="添加投票";
?>
<?php echo Html::beginForm(Url::to(['vote/add']));?>
<div class="form-group form-subject">
	<div class="form-lable"><?php echo Html::label('投票主题：','subject');?></div>
	<div class="form-input">
		<?php echo Html::activeTextarea($model, 'subject',[
    	    'placeholder'=>'请填写投票内容说明(2-80字)',
    	    'data-sy-required'=>true,
    	    'data-sy-required-message'=>'主题不能为空'
    	]);?>
	</div>
</div>
<div class="form-group form-voteoptions">
	<div class="form-lable"><?php echo Html::label('投票选项：','voteoptions')?></div>
	<div class="form-input">
		<?php for ($i = 0;$i < count($model->voteoptions);$i++ ){?>
        	<p>
        		<?php echo Html::activeTextInput($model, 'voteoptions['.$i.']',['placeholder'=>'选项'.($i+1)]);?>
        		<?php if($i>=2){?>
        			<a class="delete-btn" href="javascript:;" title="删除"><i>✖</i></a>
        		<?php }?>
        	</p>
    	<?php }?>
    	
    	<a id="addoptions"  href="javascript:;"><i>✚</i>添加选项</a>
	</div>
</div>
<div class="form-group form-selectType">
	<div class="form-lable"><?php echo Html::label('选择模式：','selectType')?></div>
	<div class="form-input">
		<?php echo Html::activeRadioList($model, 'selectType', ['single'=>'单选','multi'=>'多选'])?>
	</div>
</div>

<div class="form-group form-date">
	<div class="form-lable"><?php echo Html::label('投票时间：','endDate')?></div>
	<div class="form-input">
		<?php 
		echo Html::activeTextInput($model, 'startDate',['class'=>'datepicker','style'=>'width:241px','placeholder'=>'开始时间','readonly'=>true]),' - ',Html::activeTextInput($model, 'endDate',['class'=>'datepicker','style'=>'width:241px','placeholder'=>'结束时间','readonly'=>true])
        ?>
	</div>
</div>
<div>
	<?php if(Yii::$app->session->hasFlash('error')){ echo Yii::$app->session->getFlash('error');} ?>
</div>

<div class="form-group form-btn">
	<?php echo Html::submitInput('确认保存',['class'=>'btn btn-primary']);?>
	<?php echo Html::resetInput('清空重置',['class'=>'btn'])?>
</div>

<?php echo Html::endForm();?>

<?php 
    AppAsset::addCss($this, 'admin/css/voteAdd.css');
    AppAsset::addCss($this, 'admin/jquery-ui-1.12.1/jquery-ui.min.css');
    AppAsset::addScript($this, 'admin/jquery-ui-1.12.1/jquery-ui.min.js');
    $optionCount = count($model->voteoptions) + 1 ;
    $js = <<<JS
var optionCount = $optionCount;
$(document).on('click','.delete-btn',function(e){
	$(this).parent().parent('div').find('p:last').remove();
});
$(document).on('click','#addoptions',function(e){
    var optionHtml = '<p><input type="text" id="vote-voteoptions" name="Vote[voteoptions][]" placeholder="选项'+optionCount+'"><a class="delete-btn" href="javascript:;" title="删除"><i>✖</i></a></p>';
    $(this).parent('div').find('p:last').after(optionHtml);
    optionCount ++;
});
$(".datepicker").datepicker({
    dateFormat :'yy-mm-dd',
    minDate: new Date(),
    monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'], 
    monthNamesShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
    dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'], 
    dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'], 
    dayNamesMin: ['日','一','二','三','四','五','六'], 
});
dayNames = $('.datepicker').datepicker('option', 'dayNames');
console.log(dayNames);
JS;
    $this->registerJs($js);
?>

