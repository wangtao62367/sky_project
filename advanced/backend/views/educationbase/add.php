<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['teachplace/manage'])?>">教育基地管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
    <li><label>基地名称<b>*</b></label><?php echo Html::activeTextInput($model, 'baseName',['class'=>'dfinput'])?><i>教育基地名称不能超过10个字符</i></li>
    <li><label>基地图片<b>*</b></label>
    <?php echo Html::fileInput('image','',['class'=>'uploadFile','id'=>"uploadFile","accept"=>"image/png, image/jpeg,image/jpg"]);?>
    <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
    <div href="javascript:;" class="image-box">
    	<?php if(!empty($model->baseImg)):?>
    		<img alt="" width="100%" height="170px" src="<?php echo $model->baseImg;?>" />
    	<?php else :?>
    		<img alt="" src="/admin/images/ico04.png" />
    	<?php endif;?>
    </div>
    <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片.（建议图片尺寸为：250像素 * 148像素）</i>
    </li>
    <li><label>链接地址<b>*</b></label><?php echo Html::activeTextInput($model, 'link',['class'=>'dfinput'])?><i>基地链接地址必须是URL全路径，否则跳转失败；如：百度 http://www.baidu.com </i></li>
    <li><label>排序</label>
    	<?php echo Html::activeInput('number', $model, 'sorts',['class'=>'dfinput']);?><i>数字越小排序越靠前</i>
    </li>
    <?php if(Yii::$app->session->hasFlash('error')):?>
    	<li><label>&nbsp;</label><span class="error-tip"><?php echo Yii::$app->session->getFlash('error');?></span></li>
    <?php endif;?>
    <li><label>&nbsp;</label><?php echo Html::submitInput('确认保存',['class'=>'btn'])?></li>
</ul>
<?php echo Html::endForm();?>
</div>

<?php 
$js = <<<JS
$('#btn-select-image').click(function(){
    $('#uploadFile').click();
});
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
   $('#selectedImg').text(file.name);
})

JS;
$this->registerJs($js);
AppAsset::addCss($this, '/admin/css/webset.css');
?>