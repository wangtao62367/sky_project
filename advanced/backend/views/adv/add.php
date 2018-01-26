<?php


use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Adv;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['adv/manage'])?>">广告列表</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['id'=>'myform','enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
    
    
    <li><label>广告词<b>*</b></label>
    <?php echo Html::activeTextInput($model, 'advs',['class'=>'dfinput'])?><i>广告词限制2到10字</i>
    </li>
    <li><label>上传图片</label>
    <?php echo Html::activeHiddenInput($model,'oldImgs',['id'=>'oldImgs']);?>
    <?php echo Html::activeHiddenInput($model, 'imgs',['class'=>'dfinput','id'=>'imgs'])?>
    <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
    <div href="javascript:;" class="image-box">
    	<?php if(!empty($model->imgs)):?>
    		<img alt="" width="100%" src="<?php echo $model->imgs;?>" />
    	<?php else :?>
    		<img alt="" src="/admin/images/ico04.png" />
    	<?php endif;?>
    </div>
    <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：270像素 * 170像素）</i>
    </li>
    <li><label>广告位置<b>*</b></label>
    	<div class="vocation">
            <?php echo Html::activeDropDownList($model, 'position', Adv::$position_text,['prompt'=>'请选择','class'=>'sky-select'])?><i>每个位置只能有一个广告</i>
        </div>
    </li>
    <li><label>状态<b>*</b></label>
    	<?php echo Html::activeRadioList($model, 'status', ['1'=>'开启','0'=>'关闭'],['value'=>1])?>
    </li>
    <li><label>广告链接</label><?php echo Html::activeTextInput($model, 'link',['class'=>'dfinput'])?><i>链接地址必须是URL全路径,例如：百度 http://www.baidu.com</i></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS

CSS;
$js = <<<JS

$('#uploadFile').change(function(){
    var file = this.files && this.files[0];
    console.log(file.type);
    var maxSize = 500 * 1025;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];

    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
    $("#selectedImg").text(file.name);
    //uploadFile();
})
 
$('#btn-select-image').on('click', '', function() {
    $('#uploadFile').click();
    
});
JS;
AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
// $this->registerCss($css);
?>