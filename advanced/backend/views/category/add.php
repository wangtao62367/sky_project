<?php


use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;
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
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['category/manage'])?>">教师管理</a></li>
        <li><a href="<?php echo Url::to($url)?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>分类名称<b>*</b></label><?php echo Html::activeTextInput($model, 'text',['class'=>'dfinput'])?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <li><label>分类类别<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'type', Category::$type_arr,['prompt'=>'请选择','class'=>'select1'])?>
    	</div>
    </li>
    <li><label>所属板块<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'parentId', ArrayHelper::map($parentCates,'id','codeDesc'),['prompt'=>'请选择','class'=>'select1'])?>
    	</div>
    </li>
    <li><label>分类描述</label><?php echo Html::activeTextarea($model, 'descr',['class'=>'textinput'])?><i></i></li>
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