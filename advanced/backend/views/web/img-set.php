<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;


?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['web/setting'])?>">网站基础设置</a></li>
    </ul>
</div>

<div class="formbody">
<div class="formtitle">
<a href="javascript:;"><span class="active">网站基础设置</span></a>
<a href="<?php echo Url::to(['web/img-set'])?>"><span>图片设置</span></a>
<a href="<?php echo Url::to(['web/watermark-set'])?>"><span>图片水印设置</span></a>
</div>

<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
    <li><label>顶部背景图</label>
        <?php echo Html::fileInput('indexTopBg','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexTopBg'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['indexTopBg'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为 2000像素 * 200像素</i>
    </li>
    
    <li><label>底部背景图</label>
        <?php echo Html::fileInput('indexBottomBg','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexBottomBg'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['indexBottomBg'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为 1200像素 * 220像素</i>
    </li>
    
    <li><label>底部单位标志</label>
        <?php echo Html::fileInput('indexBottomSign','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexBottomSign'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['indexBottomSign'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为 200像素 * 200像素</i>
    </li>
    
    <li><label>首页中央横条1</label>
        <?php echo Html::fileInput('indexMainBanner1','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexMainBanner1'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['indexMainBanner1'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为 1200像素 * 100像素</i>
    </li>
    
     <li><label>首页中央横条2</label>
        <?php echo Html::fileInput('indexMainBanner2','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['indexMainBanner2'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['indexMainBanner2'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为 1200像素 * 100像素</i>
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
.image-box{
	width:100%;
}
CSS;
$js = <<<JS
$(document).on('click','input[name=status]',function(){
    var status = $(this).val();    
    if(status == 1){
        $('.closeReasons').hide();
    }else{
        $('.closeReasons').show();
    }
});
$(document).on('click','#btn-select-image',function(){
	$('#uploadFile').click();
})
$('#uploadFile').change(function(){
    var file = this.files && this.files[0];
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
})
JS;
AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>