<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻管理系统</a></li>
        <li><a href="<?php echo Url::to(['famous-teacher/list'])?>">名师堂</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['id'=>'myform','enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
	 <li><label>名师头像<b>*</b></label>
    <?php echo Html::fileInput('avater','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a>
    	<i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：70像素 * 100像素）</i>
    	<p id="selectedImg"></p> 
    </div>
    <?php if(!empty($model->avater)):?>
    <div href="javascript:;" class="image-box">
    		<img alt="" width="100%" height="150px" src="<?php echo $model->avater;?>" />
    </div>
    <?php endif;?>
    </li>
   
    <li><label>姓名<b>*</b></label><?php echo Html::activeTextInput($model, 'name',['class'=>'dfinput'])?></li>
    <li><label>授课内容<b>*</b></label><?php echo Html::activeTextInput($model, 'teach',['class'=>'dfinput'])?></li>
    <li><label>个人介绍<b>*</b></label>
    	<div style="margin-left:86px;width:900px;height:500px" id="content" name="FamousTeacher[intro]"></div>
    </li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
.uploadFile{
display:none
}
.image-box {
    width: 100px;
    height: 150px;
    line-height: 150px;
}
CSS;
$uploadurl = Url::to(['famous-teacher/upload']);
$content = $model->intro;
$js = <<<JS

var ue = UE.getEditor('content', {
	serverUrl : '$uploadurl',
});

 ue.ready(function() {
    ue.setContent('$content');

});

$('#uploadFile').change(function(){
    var file = this.files && this.files[0];
    console.log(file.type);
    var maxSize = 500 * 1025;//500kb
    var ext = ['image/jpeg','image/png','image/jpg'];
    console.log($.inArray(file.type,ext));
    if(file.size > maxSize){
        alert("所选图片大小不能超过500KB");return;
    }
    if($.inArray(file.type,ext) == -1){
        alert("所选图片格式只能是jpg、png或jpeg");return;
    }
    $('#selectedImg').text(file.name);
    //uploadFile();
})
 
$('#btn-select-image').on('click', '', function() {
     $('#uploadFile').click();
});
JS;
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.config.js');
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.all.min.js');
AppAsset::addCss($this, '/admin/css/webset.css');
$this->registerJs($js);
$this->registerCss($css);
?>