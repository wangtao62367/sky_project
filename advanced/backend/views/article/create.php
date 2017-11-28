<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Widget;

$this->title='创建文章';

?>

<?php echo Html::beginForm();?>
<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('文章标题：','title');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'title',[
    	    'placeholder'=>'请填写分类名称(10-100字)',
    	]);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('图片标题：','titleImg');?></div>
	<div class="form-input">
		<?php echo Html::activeFileInput($model, 'titleImg');?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('文章作者：','author');?></div>
	<div class="form-input">
		<?php echo Html::activeTextInput($model, 'author',[
    	    'placeholder'=>'请填写文章作者',
		    'style'=>'width:100px'
    	]);?>
	</div>
</div>

<div class="form-group form-subject">
	<div class="form-lable"><?php echo Html::label('文章摘要：','summary');?></div>
	<div class="form-input">
		<?php echo Html::activeTextarea($model, 'summary',[
    	    'placeholder'=>'请填写文章摘要(20-200字)']);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('文章分类：','categoryId');?></div>
	<div class="form-input">
		<?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates, 'id', 'text') , ['prompt'=>'请选择','prompt_val'=>'0','style'=>'width:100px']);?>
	</div>
</div>

<div class="form-group form-positions">
	<div class="form-lable"><?php echo Html::label('文章内容：','content');?></div>
	<div class="form-input">
		<?php echo \kucha\ueditor\UEditor::widget([
		    'model' => $model,
            'attribute' => 'content',
		    'clientOptions'=>[
		        'lang'=>'zh-cn',
		        //编辑区域大小
		        'initialFrameHeight' => '500',
		        'initialFrameWidth'  => '1200'
		     ]
		]);?>
	</div>
</div>

<div class="form-group ">
	<div class="form-lable"><?php echo Html::label('文章标签：','tags');?></div>
	<div class="form-input" style="width:500px">
		<?php echo \common\widgets\tags\TagWidget::widget([
		    'model'=>$model,
		    'attribute'=>'tags',
		    
		]);?>
	</div>
</div>


<?php if(Yii::$app->session->hasFlash('success')){
         echo Yii::$app->session->getFlash('success');
      }else{
         echo Yii::$app->session->getFlash('error');
      }
?>

<div class="form-group form-btn">
	<?php echo Html::submitInput('确认保存',['class'=>'btn btn-primary']);?>
	<?php echo Html::resetInput('清空重置',['class'=>'btn'])?>
</div>

<?php echo Html::endForm();?>

<?php 
AppAsset::addCss($this, 'admin/css/form.css');
$css = <<<CSS
.select2-container--default .select2-selection--multiple {
    background-color: white;
    border: 1px solid #aaa;
    cursor: text;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #2b542c;
    outline: 0 none;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
	background-color: #5cb85c;
	color:#fff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	color:#fff;
}
CSS;

$js = <<<JS

JS;
$this->registerCss($css);
$this->registerJs($js);
?>