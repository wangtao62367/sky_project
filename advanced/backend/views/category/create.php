<?php
use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\ArrayHelper;

$this->title="创建分类";

?>
<?php echo Html::beginForm();?>
<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('分类名称：','text');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'text',[
    	    'placeholder'=>'请填写分类名称(2-20字)',
		    'autocomplete'=>'off',
    	    'data-sy-required'=>true,
    	    'data-sy-required-message'=>'分类名称不能为空'
    	]);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('所属模块：','parentId');?></div>
	<div class="form-input">
		<?php echo Html::activeDropDownList($model, 'parentId', array_merge([''=>'请选择'],ArrayHelper::map($parentCates, 'id', 'codeDesc')) );?>
	</div>
</div>

<div class="form-group form-positions">
	<div class="form-lable"><?php echo Html::label('类型归类：','type');?></div>
	<div class="form-input">
		<?php echo Html::activeRadioList($model, 'type', $model->type_arr);?>
	</div>
</div>


<div class="form-group form-subject">
	<div class="form-lable"><?php echo Html::label('分类描述：','descr');?></div>
	<div class="form-input">
		<?php echo Html::activeTextarea($model, 'descr',[
    	    'placeholder'=>'请填写分类说明(5-100字)',
		    'autocomplete'=>'off'
		]);?>
	</div>
</div>

<p style="color:red"><?php if(Yii::$app->session->getFlash('error')){ echo Yii::$app->session->getFlash('error');}?></p>
<p style="color:green"><?php if(Yii::$app->session->getFlash('success')){ echo Yii::$app->session->getFlash('success');}?></p>
<div class="form-group form-btn">
	<?php echo Html::submitInput('确认保存',['class'=>'btn btn-primary']);?>
	<?php echo Html::resetInput('清空重置',['class'=>'btn'])?>
</div>
<?php echo Html::endForm();?>

<?php 
AppAsset::addCss($this, 'admin/css/form.css');

$js = <<<JS

JS;
$this->registerJs($js);
?>