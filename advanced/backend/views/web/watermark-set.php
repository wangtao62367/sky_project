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
	<a href="javascript:;"><span class="active">图片水印设置</span></a>
	<a href="<?php echo Url::to(['web/clear-cache'])?>"><span>缓存清理</span></a>
	<a href="<?php echo Url::to(['web/indexbanner-set'])?>"><span >首页banner图设置</span></a>

	</div>

	<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data",'id'=>'myForm']);?>
<ul class="forminfo">
	<li><label>水印类型</label>
		<?php echo Html::radioList('watermarkCate',$webCfg['watermarkCate'],['text'=>'文字','image'=>'图片'],['id'=>'watermarkCate'])?>
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
        		<img alt="" width="50px" src="<?php echo $webCfg['watermarkContent'];?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>水印图片建议宽高为50像素 * 50像素;大小控制在10kb以内;(水印图片不能太大)</i>
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
    <li class="li-input-btn"><label>&nbsp;</label><?php echo Html::buttonInput('确认保存',['id'=>'submitBtn','class'=>'btn'])?></li>
</ul>

</div>

<?php 
$css = <<<CSS
.imageSet{display:none}
.image-box{
    width:100px;
    height:100px;
    line-height: 100px;
    display: inline-block;
    text-align: center;
    border: 1px solid #666;
    border-style: dotted;
    margin-top: 10px;
    margin-left: 86px;
    overflow: hidden;
}
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
    var maxSize = 30 * 1024 * 10;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];
    if(file.size > maxSize){
        error = '所选图片大小不能超过10KB';
        alert("所选图片大小不能超过10KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        error = '所选图片格式只能是jpg、png或jpeg';
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
	$("#selectedImg").text(file.name);
    testWidthHeight(file);
    //uploadFile();
})

var isAllow = false;
var error = '';
$('#submitBtn').click(function(){
     var watermarkCate = $("input[type='radio']:checked").val();;    
    if(watermarkCate == 'text'){
        $('#myForm').submit();
    }else{
        if(isAllow){
            $('#myForm').submit();
        }else{
            alert(error);
        }
    }
    
});


function testWidthHeight(file){
      debugger;
    var fileData = file;
    //读取图片数据
  var reader = new FileReader();
  reader.onload = function (e) {
      var data = e.target.result;
      //加载图片获取图片真实宽度和高度
      var image = new Image();
      image.onload=function(){
          var width = image.width;
          var height = image.height;
          if(width > 50 || height >50){
                error = '水印图片宽高必须小于50像素';
               alert('水印图片宽高必须小于50像素');
          }else{
                isAllow = true;
           }
            
     };
     image.src= data;
  };
  reader.readAsDataURL(fileData);
}

JS;

AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>