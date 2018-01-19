<?php


use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['category/manage'])?>">分类管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	<?php $inputExtends = []; if($model->isBase == 1){$inputExtends = ['disabled'=>true];}?>
    <li><label>分类名称<b>*</b></label><?php echo Html::activeTextInput($model, 'text',ArrayHelper::merge($inputExtends, ['class'=>'dfinput']))?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <li><label>分类类别<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'type', Category::$type_arr,ArrayHelper::merge($inputExtends, ['prompt'=>'请选择','class'=>'sky-select']))?>
    	</div>
    </li>
    <li><label>所属板块<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'parentId', ArrayHelper::map($parentCates,'id','codeDesc'),['prompt'=>'请选择','class'=>'sky-select'])?>
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
JS;
$this->registerJs($js);
?>