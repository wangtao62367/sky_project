<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;


?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['web/watermark-set'])?>">网站基础设置</a></li>
    </ul>
</div>

<div class="formbody">
	<div class="formtitle">
	<a href="<?php echo Url::to(['web/setting'])?>"><span>网站基础设置</span></a>
	<!-- <a href="<?php echo Url::to(['web/img-set'])?>"><span>图片设置</span></a> -->
	<a href="javascript:;"><span class="active">图片水印设置</span></a>
	</div>

	<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
	<li><label>水印类型</label>
		<?php echo Html::radioList('watermarkCate',$webCfg['watermarkCate'],['text'=>'文字','image'=>'图片'])?>
	</li>
	<li class="fontSet"><label>文字内容</label>
		<?php echo Html::textInput('watermarkContent',$webCfg['watermarkContent'],['class'=>'dfinput'])?>
	</li>
	<li class="fontSet"><label>文字大小</label>
		<?php echo Html::textInput('watermarkTextFont',$webCfg['watermarkTextFont'],['class'=>'dfinput'])?>
	</li>
	<li class="fontSet"><label>文字颜色</label>
		<?php echo Html::textInput('watermarkTextColor',$webCfg['watermarkTextColor'],['class'=>'dfinput'])?><i>填写16进制颜色值；如：黑色就填  000000</i>
	</li>
	<li class="imageSet"><label>水印图片</label>
		<?php echo Html::hiddenInput('oldwaterImage', $webCfg['watermarkContent'],['id'=>'oldwaterImage']);?>
        <?php echo Html::hiddenInput('waterImage', $webCfg['watermarkContent'],['id'=>'waterImage'])?>
        <?php echo Html::fileInput('file','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if($webCfg['watermarkCate'] == 'image'):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['watermarkContent'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>水印图片建议宽高为120像素 * 50像素;大小控制在500kb以内</i>
	</li>
	<li><label>水印位置</label>
		<div class="vocation">
            <?php echo Html::dropDownList('watermarkPosition', $webCfg['watermarkPosition'], [
            		'1'=>'左上',
            		'2'=>'中上',
            		'3'=>'右上',
            		'4'=>'左中',
            		'5'=>'正中',
            		'6'=>'右中',
            		'7'=>'左下',
            		'8'=>'中下',
            		'9'=>'右下'
            ],['id'=>'watermarkPosition','class'=>'sky-select'])?>
        </div>
	</li>
	<?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>

</div>

<?php 
$css = <<<CSS
.imageSet{display:none}
CSS;
$watermarkCate = $webCfg['watermarkCate'];
$js = <<<JS
initView('$watermarkCate');
function initView(cate){
    if(cate == 'text'){
		$('.fontSet').show();
		$('.imageSet').hide();
	}else{
		$('.imageSet').show();
		$('.fontSet').hide();
	}
}
$(document).on('click','input[name=watermarkCate]',function(){
	var val = $(this).val();
	initView(val);
})
$(document).on('click','#btn-select-image',function(){
	$('#uploadFile').click();
})
$('#uploadFile').change(function(){
    var file = this.files && this.files[0];
    console.log(file);
    var maxSize = 500 * 1025;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];
    console.log($.inArray(file.type,ext));
    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
	$("#selectedImg").text(file.name);
    //uploadFile();
})
JS;

AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>