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
<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、分类所属类型包括：文章、图片、视频、文件、特殊类型。特殊类型即为个性化设置的类型模块</li>
		<li>2、系统设定的分类不能删除，且只能修改所属模块；只有自定义新增的分类可以修改和删除操作 </li>
		<li>3、分类有添加或编辑等操作，请前往基础配置进行缓存清理，否则前台页面不会生效 </li>
	</ul>
</div>

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
	<?php $inputExtends = []; if($model->isBase == 1){$inputExtends = ['disabled'=>true];}?>
    <li><label>分类名称<b>*</b></label><?php echo Html::activeTextInput($model, 'text',['class'=>'dfinput'])?><i>教师名称不能为空，且长度为2-20个字</i></li>
    <li><label>分类类别<b>*</b></label>
    	<div class="vocation">
    		<?php if($model->type != 'orther'):?>
    			<?php echo Html::activeDropDownList($model, 'type', Category::$type_arr2,['prompt'=>'请选择','class'=>'sky-select'])?>
    		<?php else:?>
    			<?php echo Html::activeDropDownList($model, 'type', ['orther'=>'特殊类型'],['class'=>'sky-select'])?>
    		<?php endif;?>
    	</div>
    </li>
    <li><label>所属板块<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'parentId', ArrayHelper::map($parentCates,'id','codeDesc'),array_merge($inputExtends,['prompt'=>'请选择','class'=>'sky-select']));?>
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