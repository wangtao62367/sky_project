<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['carousel/manage'])?>">图片模块</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>

<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
	<li class="img-upload"><label>上传图片<b>*</b></label>
		<?php echo Html::activeHiddenInput($model, 'img');?>
        <?php echo Html::fileInput('file','',['class'=>'uploadFile','style'=>'display:none','id'=>"uploadFile",'accept'=>"image/png, image/jpeg,image/jpg"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($model->img)):?>
        		<img alt="" width="100%" src="<?php echo $model->img;?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：778像素 * 367像素）</i>
	</li>
	
	<li><label>跳转连接<b>*</b></label>
		<?php echo Html::activeTextInput($model, 'link',['class'=>'dfinput','placeholder'=>'跳转连接必须是URL全连接；如：百度 http://www.baidu.com'])?>
		<i>跳转连接必须是URL全连接；如：百度 http://www.baidu.com</i>
	</li>
	
	<li><label>轮播标题<b>*</b></label>
		<?php echo Html::activeTextInput($model, 'title',['class'=>'dfinput'])?>
	</li>
	
	<li><label>排序<b>*</b></label>
		<?php echo Html::activeInput('number',$model, 'sorts',['class'=>'dfinput','placeholder'=>'数字越小排序越靠前'])?>
		<i>数字越小排序越靠前</i>
	</li>
	<?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
	<li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>
<?php 
$css =<<<CSS
.image-box{
    height:367px;
    width:778px;
    border:1px solid #333;
    border-style: dashed;
    border-radius: 5px;
    margin-left: 86px;
    margin-top: 20px;
    text-align: center;
    line-height: 367px;
}
.img-upload i,#selectedImg{margin-left: 86px;margin-top: 10px;display: inline-block;}
.btn {
    width: 137px;
    height: 35px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    line-height: 35px;
    text-align: center;
}
#btn-select-image:hover{background:#145880;color:#fff;border-radius: 5px;}

CSS;

$js =<<<JS
//文章主图上传
$(document).on('click','#btn-select-image',function(){
	$('#uploadFile').click();
})
$('#uploadFile').change(function(){
    var file = this.files && this.files[0];
    var maxSize = 500 * 1025;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];
    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
	$("#selectedImg").text(file.name);
})
JS;


$this->registerJs($js);
$this->registerCss($css);

?>