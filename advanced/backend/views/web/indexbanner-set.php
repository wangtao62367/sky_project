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
	<a href="<?php echo Url::to(['web/watermark-set'])?>"><span>图片水印设置</span></a>
	<a href="<?php echo Url::to(['web/clear-cache'])?>"><span>缓存清理</span></a>
		<a href="javascript:;"><span class="active">首页banner图设置</span></a>
	</div>

	<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data",'id'=>'myForm']);?>
<ul class="forminfo">
	
	<li class="imageSet"><label>首页Banner1</label>
        <?php echo Html::hiddenInput('indexMainBanner1', $webCfg['indexMainBanner1'],['id'=>'indexMainBanner1'])?>
        <?php echo Html::fileInput('indexMainBanner1','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg,image/gif"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn btn-select-image" >选择图片</a><p class="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexMainBanner1'])):?>
        		<img alt="" width="400px" src="<?php echo $webCfg['indexMainBanner1'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <br/>
        <i>首页Banner1图片建议宽高为580像素 * 100像素;大小控制在500kb以内;</i>
	</li>
	
	<li>
    	<label>Banner1链接</label>
    	<?php echo Html::textInput('indexMainBanner1Link',$webCfg['indexMainBanner1Link'],['class'=>'dfinput','placeholder'=>'banner1的链接地址']);?><i>链接地址必须是全路径；如：百度 http://www.baidu.com</i>
    </li>
	
	
	<li class="imageSet"><label>首页Banner2</label>
        <?php echo Html::hiddenInput('indexMainBanner2', $webCfg['indexMainBanner2'],['id'=>'indexMainBanner2'])?>
        <?php echo Html::fileInput('indexMainBanner2','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg,image/gif"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn btn-select-image" >选择图片</a><p class="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexMainBanner2'])):?>
        		<img alt="" width="400px" src="<?php echo $webCfg['indexMainBanner2'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <br/>
        <i>首页Banner2图片建议宽高为580像素 * 100像素;大小控制在500kb以内;</i>
	</li>
	
	<li>
    	<label>Banner2链接</label>
    	<?php echo Html::textInput('indexMainBanner2Link',$webCfg['indexMainBanner2Link'],['class'=>'dfinput','placeholder'=>'banner2的链接地址']);?><i>链接地址必须是全路径；如：百度 http://www.baidu.com</i>
    </li>
	
	<?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::submitButton('确认保存',['id'=>'submitBtn','class'=>'btn'])?></li>
</ul>

<?php echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
.image-box {
    width: 400px;
    height: 80px;
   line-height: 80px;
}
.btn-select-image {
    padding: 0px;
    height: 25px;
    line-height: 25px;
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    text-decoration: none;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}

CSS;
$js = <<<JS
$(document).on('click','.btn-select-image',function(){
    var fileBtn = $(this).parents('.imageSet').find('input[type=file]');
	fileBtn.click();
})

$(document).on('change','input[type=file]',function(){
    var file = this.files && this.files[0];
    console.log(file);
    var maxSize = 500 * 1025;//500kb
    var ext = ['image/jpeg','image/png','image/jpg','image/gif'];
    console.log($.inArray(file.type,ext));
    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、gif、png或jpeg");return;
    }
    $(this).parents('.imageSet').find('.selectedImg').text(file.name);
})
JS;

AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>

