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
        <li><a href="<?php echo Url::to(['image/manage'])?>">图片模块</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>

<?php echo Html::beginForm('','post',['enctype'=>"multipart/form-data"]);?>
<ul class="forminfo">
	<li><label>上传图片<b>*</b></label>
        <?php echo Html::fileInput('files','',['class'=>'uploadFile','id'=>"uploadFile"]);?>
        <div class="select-btn-box"><a href="javascript:;" class="btn"  id="btn-select-image">选择图片</a><p id="selectedImg"></p></div>
        <div href="javascript:;" class="image-box">
        	<?php if(!empty($model->img)):?>
        		<img alt="" width="100%" src="<?php echo $model->img;?>" />
        	<?php else :?>
        		<img alt="" src="/admin/images/ico04.png" />
        	<?php endif;?>
        </div>
        <i>图片大小不超过500KB，且格式必须是png、jpeg或jpg的图片。（建议图片尺寸为：270像素 * 170像素）</i>
	</li>
	
	<li><label>跳转连接</label>
		<?php echo Html::activeTextInput($model, 'link',['class'=>'dfinput'])?>
	</li>
	
	<li><label>轮播标题</label>
		<?php echo Html::activeTextInput($model, 'link',['class'=>'dfinput'])?>
	</li>
	
	<li><label>排序</label>
		<?php echo Html::activeInput('number',$model, 'link',['class'=>'dfinput'])?>
	</li>
</ul>
<?php echo Html::endForm();?>
</div>