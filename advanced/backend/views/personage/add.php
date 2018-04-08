<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$param = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge($param, [$controller->id.'/'.$controller->action->id]));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['personage/manage','Personage[search][role]'=>$model->role])?>">社院人物管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
	<li><label>人物角色<b>*</b></label>
    	<div class="vocation">
            <?php echo Html::activeDropDownList($model, 'role', ArrayHelper::map($roles,'code','codeDesc'),['prompt'=>'请选择','class'=>'sky-select','disabled'=>'true'])?>
        </div>
    </li>
    
    <li><label>人物姓名<b>*</b></label><?php echo Html::activeTextInput($model, 'fullName',['class'=>'dfinput'])?></li>
    <li><label>人物头像<b>*</b></label>
    <?php echo Html::activeHiddenInput($model, 'photo',['class'=>'dfinput','id'=>'photo'])?>
    <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if($model->photo):?>
        		<img alt="" width="100%" src="<?php echo $model->photo;?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>头像建议宽高为100像素 * 100像素;大小控制在500kb以内</i>
    </li>
    <li><label>职        务<b>*</b></label><?php echo Html::activeTextInput($model, 'duties',['class'=>'dfinput'])?></li>
    <li><label>个人简介</label><?php echo Html::activeTextarea($model, 'intruduce',['class'=>'textinput'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
AppAsset::addCss($this, '/admin/css/webset.css');

$css = <<<CSS
.image-box{width:120px;height:120px;line-height:120px;}
CSS;
$js = <<<JS
$(document).on('click','#btn-select-image',function(){
    $("#uploadFile").click();
})
$(document).on('change',"#uploadFile",function(){
    var file = this.files && this.files[0];
    var maxSize = 500 * 1024;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];
    console.log($.inArray(file.type,ext));
    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
   $('#selectedImg').text(file.name);
})

JS;
$this->registerJs($js);
$this->registerCss($css);
?>