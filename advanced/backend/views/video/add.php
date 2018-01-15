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
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['video/manage'])?>">视频模块</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['id'=>'myform']);?>
<ul class="forminfo">
	<li><label>上传视频<b>*</b></label>
	<?php echo Html::activeHiddenInput($model,'oldVideo',['id'=>'oldVideo']);?>
    <?php echo Html::activeHiddenInput($model, 'video',['class'=>'dfinput','id'=>'video'])?>
    <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadVideo","accept"=>"video/mp4"]);?>
    <div style="margin-left: 86px">
    		<div id="btn-select-video"></div><p><i>视频上传过程中，切勿做其他操作</i></p>
    		<?php if(!empty($model->video)):?>
    		<div>已上传视频链接：<?php echo $model->video;?></div>
    		<?php endif;?>
    </div>
	</li>
    <li><label>视频背景图<b>*</b></label>
    <?php echo Html::activeHiddenInput($model,'oldVideoImg',['id'=>'oldVideoImg']);?>
    <?php echo Html::activeHiddenInput($model, 'videoImg',['class'=>'dfinput','id'=>'videoImg'])?>
    <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <a href="javascript:;" id="btn-select-image">
    	<?php if(!empty($model->videoImg)):?>
    		<img alt="" width="100%" height="170px" src="<?php echo $model->videoImg;?>" />
    	<?php else :?>
    		<img alt="" src="/admin/images/ico04.png" />
    	<?php endif;?>
    </a>
    <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：270像素 * 170像素）</i>
    </li>
    <li><label>视频分类<b>*</b></label>
    	<div class="vocation">
            <?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','id'=>'categoryId','class'=>'sky-select'])?>
        </div>
    </li>
    <li><label>视频描述<b>*</b></label><?php echo Html::activeTextInput($model, 'descr',['class'=>'dfinput','id'=>'descr'])?></li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><a href="javascript:;" class="btn" id="formSubmit">确认保持</a> <?php // echo Html::submitInput('确认保存',['class'=>'btn','id'=>'formSubmit'])?></li>
</ul>
<?php  echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
.uploadFile{
display:none
}
#btn-select-image{
    width: 267px;
    height: 164px;
    line-height: 164px;
    display: inline-block;
    text-align: center;
    border: 1px solid #666;
    border-style: dotted;
}
#selectfiles{
    padding : 0px;
    height: 34px;
    line-height: 34px;
    color: #fff;
}
#selectfiles:hover,#selectfiles:focus{
    color: #fff;
    background: #438af9;
}

#btn-select-image img{
display: inline-block;
vertical-align: middle;
}
.forminfo li i {
    color: #7f7f7f;
    padding-left: 0px;
    font-style: normal;
}
.btn{height:auto;}

CSS;
$url = Url::to(['alioss/manage']);
$js = <<<JS
function selectImage(){
    return  $('#uploadFile').click();
}

function selectVideo(){
    return  $('#uploadVideo').click();
}

$('#uploadVideo').change(function(){
    var file = this.files && this.files[0];

    var maxSize = 1024 * 1024 * 1024;//500kb
    var ext = ['video/mp4'];
    console.log($.inArray(file.type,ext));
    if(file.size > maxSize){
        alert("所选视频大小不能超过1GB");return;
    }  
    if($.inArray(file.type,ext) == -1){
        alert("所选视频格式只能是mp4");return;
    }
    $('.selected-video').text(file.name);
})

$('#uploadFile').change(function(){
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
    uploadFile();
})

function uploadFile(){
    var formData = new FormData();
    formData.append('file', $('#uploadFile')[0].files[0]);
    formData.append('oldFile', $("#oldFile").val());

    $.ajax({
        url : '/image/upload',
        type : 'POST',
        cache : false,
        data : formData,
        processData : false,
        contentType : false
    }).done(function(json) {
        console.log(json);
        if(json.success){
            var fileFullName = json.fileFullName;
            $('#btn-select-image').html('<img width="100%" height="170px" src="'+fileFullName+'" alt="'+fileFullName+'"/>');
            $("#oldVideoImg").val(fileFullName);
            $("#videoImg").val(fileFullName);
        }else{
            alert(json.message);
        }
    }, 'json').fail(function() {
        console.log('保存失败，请检查网络');
    });
}
    
$('#btn-select-image').click(function(){
    selectImage();
});

$('#formSubmit').click(function(){
    var videoImg = $('#videoImg').val() ;
    var categoryId = $('#categoryId').val() ;
    var descr = $('#descr').val() ;
   // var uploadVideo = $('#uploadVideo')[0].files[0] ;
    console.log(videoImg,categoryId,descr);
    if(!videoImg  || !videoImg  || !descr ){
        alert('数据不能为空');return;
    }
    $(this).prop('disabled',true);
	if($('#video').val()){
		$('#myform').submit();
	}else{
    	upload.start();
	}
});
var upload =  uploader.init({
            el : 'btn-select-video',
            btn_text : '选取视频',
            requestUrl :'$url',
            mine_types : [ //只允许上传mp4格式的视频文件
                //{ title : "Image files", extensions : "jpg,gif,png,bmp" }, 
                //{ title : "Zip files", extensions : "zip,rar" },
                { title : "Vedio files", extensions : "mp4" }
            ],
            max_file_size : 1024*1024*1024*1,  // 大小限制在 1G之内
            fileUploaded :videoUploadSuccess,　//this.vedioUploadSuccess, //上传成功
            error : function(err){
                console.log(err);
            } , //上传失败 
        });
function videoUploadSuccess(fileName){
    $('#video').val(fileName);
    $('#oldVideo').val(fileName);
	$('#myform').submit();
}

JS;
AppAsset::addScript($this, '/admin/alioss/js/plupload.full.min.js');
AppAsset::addScript($this, '/admin/alioss/js/upload.js');
AppAsset::addCss($this, '/admin/alioss/css/style.css');
$this->registerJs($js);
$this->registerCss($css);
?>