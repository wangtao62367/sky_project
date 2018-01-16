<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Widget;
use backend\models\ArticleCollectionWebsite;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['article/articles'])?>">文章管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>
<?php echo Html::beginForm();?>
<ul class="forminfo">
    <li><label>文章主题<b>*</b></label><?php echo Html::activeTextInput($model, 'title',['class'=>'dfinput'])?><i>文章主题不能为空</i></li>
    <li><label>文章摘要<b>*</b></label><?php echo Html::activeTextarea($model, 'summary',['class'=>'textinput'])?><i></i></li>
    <li><label>作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;者<b>*</b></label><?php echo Html::activeTextInput($model, 'author',['class'=>'dfinput'])?><i>文章作者不能为空</i></li>
    <li><label>分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
    	</div>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<?php echo Html::activeRadioList($model, 'isPublish', ['0'=>'否','1'=>'是'])?>
    </li>
	
	<li><label>图片数量<b>*</b></label><?php echo Html::activeTextInput($model, 'imgCount',['class'=>'dfinput','value'=>0])?><i></i></li>
	
	<li><label>远程获取内容</label><?php echo Html::activeTextInput($model, 'sourceLinke',['class'=>'dfinput','placeholder'=>'输入文章链接地址','id'=>'sourceLinke'])?>
	<a class="btn getArticle-btn">点击抓取</a>
	<div style="margin-left: 86px"><i style="    padding-left: 0px;">链接地址来源必须是人民网、新华网、中央社会主义和四川组工网，且地址必须有效，以http://或https://开始;</i></div></li>
	
    <li><label>文章内容<b>*</b></label>
    	<div style="float: left;width:900px;height:500px" id="content" name="Article[content]">
    		<?php  /* echo kucha\ueditor\UEditor::widget([
    		    'model' => $model,
                'attribute' => 'content',
    		    'clientOptions' =>[
    		        'lang' =>'zh-cn',
    		     ]
    		]) */ ?>
    	</div>
    	
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
.getArticle-btn{
	width: 137px;
    height: 35px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
	padding : 5px 10px;
}
.getArticle-btn:hover{
    color: #fff;
}
CSS;
$conllectWebsiteArr = json_encode(ArticleCollectionWebsite::$conllectWebsiteArr);
$url = Url::to(['article/conllect-content']);
$uploadurl = Url::to(['article/upload']);
$js = <<<JS
$(document).on('click','.getArticle-btn',function(){
	var sourceLinke = $('#sourceLinke').val();
	if(sourceLinke == ''){
		alert('请输入链接地址');return;
	}
	if(!checkUrl(sourceLinke)){
		alert('链接地址无效');return;
	}
    $.get('$url',{sourceLinke:encodeURI(sourceLinke)},function(res){
        console.log(res);
        if(res && res.success){
            ue.setContent(res.data);
        }
    })
	
});
var ue = UE.getEditor('content', {
	serverUrl : '$uploadurl',
});
JS;
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.config.js');
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.all.min.js');
$this->registerJs($js);
$this->registerCss($css);
?>