<?php


use yii\helpers\Url;
use yii\helpers\Html;

$controller = Yii::$app->controller;
$id= Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['admin/manage'])?>">管理员管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>管理员名称</label>
	    <div class="assiginitem-child"><label>
	    	<?php echo $admin->account ?></label>
	    </div>	
    </li>
    
    <li><label>角色</label>
    	<div class="assiginitem-child">
    		<?php echo Html::checkboxList('children',$children['roles'],$roles);?>
    	</div>
    </li>
    <li><label>权限</label>
    	<div class="assiginitem-child">
    		<?php echo Html::checkboxList('children',$children['permissions'],$permissions);?>
    	</div>
    </li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
.assiginitem-child{
margin-left : 86px;
overflow : hidden;
}
.forminfo li label {
    width: auto;
    line-height: 34px;
    display: block;
    float: left;
}
.assiginitem-child label {
	width:auto;
	margin-right:20px;
}
CSS;

$this->registerCss($css);

?>