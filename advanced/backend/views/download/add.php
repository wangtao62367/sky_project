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
        <li><a href="<?php echo Url::to(['download/manage'])?>">下载中心</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['id'=>'myform']);?>
<ul class="forminfo">
	<li><label>上传文件<b>*</b></label>
	<?php echo Html::activeHiddenInput($model,'oldUri',['id'=>'oldUri']);?>
    <?php echo Html::activeHiddenInput($model, 'uri',['class'=>'dfinput','id'=>'uri'])?>
    <div style="margin-left: 86px">
    		<div id="btn-select-video"></div><p><i>文件上传过程中，切勿做其他操作</i></p>
    		<?php if(!empty($model->uri)):?>
    		<div>已上传文件链接：<?php echo $model->uri;?></div>
    		<?php endif;?>
    </div>
	</li>

    <li><label>文件分类<b>*</b></label>
    	<div class="vocation">
            <?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','id'=>'categoryId','class'=>'sky-select'])?>
        </div>
    </li>
    <li><label>文件名称<b>*</b></label><?php echo Html::activeTextInput($model, 'descr',['class'=>'dfinput','id'=>'descr'])?></li>
    
    <li><label>图片提供者</label><?php echo Html::activeTextInput($model, 'provider',['class'=>'dfinput'])?><i></i></li>
	
	<li><label>院领导</label><?php echo Html::activeTextInput($model, 'leader',['class'=>'dfinput'])?><i></i></li>
	
	<li><label>备&nbsp;&nbsp;注</label><?php echo Html::activeTextarea($model, 'remarks',['class'=>'textinput'])?><i></i></li>
    
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><a href="javascript:;" class="btn" id="formSubmit">确认保持</a> <?php // echo Html::submitInput('确认保存',['class'=>'btn','id'=>'formSubmit'])?></li>
</ul>
<?php  echo Html::endForm();?>
</div>

<?php 
$css = <<<CSS
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

.forminfo li i {
    color: #7f7f7f;
    padding-left: 0px;
    font-style: normal;
}
.btn{height:auto;}

CSS;
$url = Url::to(['alioss/manage']);
$js = <<<JS

$('#formSubmit').click(function(){
    //var uri = $('#uri').val() ;
    var categoryId = $('#categoryId').val() ;
    var descr = $('#descr').val() ;
    if(!categoryId){
        alert('请选择文件类型');return;
    }
    if(!descr ){
        alert('请输入文件名称');return;
    }
    if(upload.files.length > 0){
        $(this).prop('disabled',true);
        upload.start();
    }else if($('#uri').val()){
        $('#myform').submit();
    }else{
        alert('请选择文件');return;
    }
});
var upload =  uploader.init({
            el : 'btn-select-video',
            btn_text : '选取文件',
            requestUrl :'$url',
            mine_types : [ //只允许上传mp4格式的视频文件
                //{ title : "Image files", extensions : "jpg,gif,png,bmp" }, 
                { title : "Zip files", extensions : "zip,rar,exe" },
                //{ title : "Vedio files", extensions : "mp4" }
            ],
            max_file_size : 1024*1024*1024*1,  // 大小限制在 1G之内
            fileUploaded :uploadSuccess,　//this.vedioUploadSuccess, //上传成功
            error : function(err){
                console.log(err);
            } , //上传失败 
        });
function uploadSuccess(fileName){
    $('#uri').val(fileName);
	$('#myform').submit();
}

JS;
AppAsset::addScript($this, '/admin/alioss/js/plupload.full.min.js');
AppAsset::addScript($this, '/admin/alioss/js/upload.js');
AppAsset::addCss($this, '/admin/alioss/css/style.css');
$this->registerJs($js);
$this->registerCss($css);
?>