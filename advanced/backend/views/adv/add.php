<?php


use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Adv;

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
<?php echo Html::beginForm();?>
<ul class="forminfo">
    
    
    <li><label>广告词<b>*</b></label>
    <?php echo Html::activeTextInput($model, 'advs',['class'=>'dfinput'])?><i>广告词限制2到10字</i>
    </li>
    <li><label>广告图</label>
    <?php echo Html::activeHiddenInput($model,'oldImgs',['id'=>'oldImgs']);?>
    <?php echo Html::activeHiddenInput($model, 'imgs',['class'=>'dfinput','id'=>'imgs'])?>
    <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <a href="javascript:;" id="btn-select-image">
    	<?php if(!empty($model->imgs)):?>
    		<img alt="" width="100%" height="170px" src="<?php echo $model->imgs;?>" />
    	<?php else :?>
    		<img alt="" src="/admin/images/ico04.png" />
    	<?php endif;?>
    </a>
    <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：侧边为 100像素 * 200像素；上下为 200 * 100像素）</i>
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

#btn-select-image img{
display: inline-block;
vertical-align: middle;
}

CSS;
$js = <<<JS

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
    uploadFile();
})

function uploadFile(){
    var formData = new FormData();
    formData.append('file', $('#uploadFile')[0].files[0]);
    formData.append('oldFile', $("#oldImgs").val());
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
            $('#btn-select-image').html('<img width="100%" src="'+fileFullName+'" alt="'+fileFullName+'"/>');
            $("#oldImgs").val(fileFullName);
            $("#imgs").val(fileFullName);
        }else{
            alert(json.message);
        }
    }, 'json').fail(function() {
        console.log('保存失败，请检查网络');
    });
}
    
$('#btn-select-image').on('click', '', function() {
    //select();
    $('#uploadFile').click();
    
});
JS;

$this->registerJs($js);
$this->registerCss($css);
?>