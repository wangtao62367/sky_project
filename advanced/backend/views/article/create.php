<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Widget;

$controller = Yii::$app->controller;
$param = isset($_GET['id']) ? $_GET['id'] : '';
$url = [
    $controller->id.'/'.$controller->action->id,
    'id' => $param
];
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['article/articles'])?>">文章管理</a></li>
        <li><a href="<?php echo Url::to($url)?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>文章主题<b>*</b></label><?php echo Html::activeTextInput($model, 'title',['class'=>'dfinput'])?><i>文章主题不能为空</i></li>
    <li><label>文章摘要<b>*</b></label><?php echo Html::activeTextarea($model, 'summary',['class'=>'textinput'])?><i></i></li>
    <li><label>作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;者<b>*</b></label><?php echo Html::activeTextInput($model, 'author',['class'=>'dfinput'])?><i>文章作者不能为空</i></li>
    <li><label>分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'select1'])?>
    	</div>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<?php echo Html::activeRadioList($model, 'isPublish', ['0'=>'否','1'=>'是'])?>
    </li>
	
	<li><label>图片数量<b>*</b></label><?php echo Html::activeTextInput($model, 'imgCount',['class'=>'dfinput','value'=>0])?><i></i></li>
	
    <li><label>文章内容<b>*</b></label>
    	<div style="float: left;width:900px">
    		<?php echo kucha\ueditor\UEditor::widget([
    		    'model' => $model,
                'attribute' => 'content',
    		    'clientOptions' =>[
    		        'lang' =>'zh-cn',
    		     ]
    		]) ?>
    	</div>
    	
    </li>
    
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$js = <<<JS
$(".select1").uedSelect({
		width : 100
	});
JS;
$this->registerJs($js);
?>