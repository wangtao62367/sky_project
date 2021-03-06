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
<!-- <a href="<?php echo Url::to(['web/img-set'])?>"><span>图片设置</span></a> -->
<a href="<?php echo Url::to(['web/watermark-set'])?>"><span>图片水印设置</span></a>
<a href="<?php echo Url::to(['web/clear-cache'])?>"><span>缓存清理</span></a>
<a href="<?php echo Url::to(['web/indexbanner-set'])?>"><span >首页banner图设置</span></a>
</div>

<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、基础配置信息有修改等操作以后， 请前往基础配置进行缓存清理，否则前台页面不会生效</li>
	</ul>
</div>  

<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
    <li><label>网站名称</label><?php echo Html::textInput('siteName',$webCfg['siteName'],['class'=>'dfinput'])?><i></i></li>
    <li><label>网站名称（2）</label><?php echo Html::textInput('siteName2',$webCfg['siteName2'],['class'=>'dfinput'])?><i></i></li>
    <li><label>网站logo</label>
    	<?php echo Html::hiddenInput('oldLogo', $webCfg['logo'],['id'=>'oldLogo']);?>
        <?php echo Html::hiddenInput('logo', $webCfg['logo'],['id'=>'logo'])?>
        <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($webCfg['logo'])):?>
        		<img alt="" width="100%" src="<?php echo $webCfg['logo'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>logo图片建议大小为140像素 * 140像素</i>
    </li>
    
    <li>
    	<label>网站主题</label>
    	<?php echo Html::textInput('siteTitle',$webCfg['siteTitle'],['class'=>'dfinput','placeholder'=>'网站主题']);?>
    </li>
    
    <li>
    	<label>网站SEO关键字</label>
    	<?php echo Html::textInput('keywords',$webCfg['keywords'],['class'=>'dfinput','placeholder'=>'网站SEO关键字']);?><i>网站SEO关键字，多个关键字使用英文的逗号隔开</i>
    </li>
    
     <li>
    	<label>网站描述</label>
    	<?php echo Html::textInput('description',$webCfg['description'],['class'=>'dfinput','placeholder'=>'网站描述']);?><i>网站描述，有利于网站SEO搜索优化</i>
    </li>
    
    <li>
    	<label>版权所有</label>
    	<?php echo Html::textInput('copyRight',$webCfg['copyRight'],['class'=>'dfinput','placeholder'=>'版权所有']);?><i>网址底部版权信息展示</i>
    </li>
    
    <li>
    	<label>技术支持</label>
    	<?php echo Html::textInput('technicalSupport',$webCfg['technicalSupport'],['class'=>'dfinput','placeholder'=>'技术支持']);?><i>网址底部技术支持展示</i>
    </li>
    
    <li>
    	<label>网站备案号</label>
    	<?php echo Html::textInput('recordNumber',$webCfg['recordNumber'],['class'=>'dfinput','placeholder'=>'网站备案号']);?><i>网站备案号</i>
    </li>
    
    <li>
    	<label>学院地址</label>
    	<?php echo Html::textInput('address',$webCfg['address'],['class'=>'dfinput','placeholder'=>'学院地址']);?><i>网址底部学院地址展示</i>
    </li>
    
    <li>
    	<label>邮        编</label>
    	<?php echo Html::textInput('postCodes',$webCfg['postCodes'],['class'=>'dfinput','placeholder'=>'邮编']);?><i>网址底部学院地址邮编展示</i>
    </li>
    
    <li>
    	<label>网站样式风格</label>
    	<?php echo Html::radioList('webStyle',$webCfg['webStyle'],['default'=>'默认','black-and-white'=>'黑白'])?>
    </li>
    
    <li>
    	<label>网站状态</label>
    	<?php echo Html::radioList('status',$webCfg['status'],['1'=>'开启','0'=>'关闭'])?>
    </li>
    
    <li class="closeReasons" <?php if($webCfg['status'] == 0) { echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
    	<label>网站关闭原因</label>
    	<?php echo Html::textarea('closeReasons','',['class'=>'textinput','placeholder'=>'网站升级中...']);?>
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

?>