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
    <li><label>文章超链接</label>
    <?php echo Html::activeTextInput($model, 'url',['class'=>'dfinput']);?><i>链接地址必须是URL全连接；如：百度 http://www.baidu.com</i>
    </li>
    <li><label>作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;者<b>*</b></label><?php echo Html::activeTextInput($model, 'author',['class'=>'dfinput'])?><i>文章作者不能为空</i></li>
    <li><label>分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'categoryId', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
    	</div>
    </li>
    <li>
    	<label>热点文章<b>*</b></label>
    	<?php echo Html::activeRadioList($model, 'ishot', ['0'=>'否','1'=>'是'],['value'=>0]);?>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<div class="vocation">
    		<?php echo Html::activeDropDownList($model, 'publishCode', $model->publishTimeArr,['class'=>'sky-select','id'=>'isPublish'])?>
    	</div>
    </li>
    
    <li class="publishTimeByUser" <?php echo $model->isPublish === 'userDefined' ? 'style="display:block"' : 'style="display:none"'; ?>><label>发布时间<b>*</b></label><?php echo Html::activeTextInput($model, 'publishTime',['class'=>'dfinput','style'=>'width:308px;','id'=>"publishTime"])?><i></i></li>
	
	<li><label>图片数量<b>*</b></label><?php echo Html::activeTextInput($model, 'imgCount',['class'=>'dfinput','value'=>0])?><i></i></li>
	
	<li><label>图片提供者</label><?php echo Html::activeTextInput($model, 'imgProvider',['class'=>'dfinput'])?><i></i></li>
	
	<li><label>院领导</label><?php echo Html::activeTextInput($model, 'leader',['class'=>'dfinput'])?><i></i></li>
	
	<li><label>远程获取内容</label><?php echo Html::activeTextInput($model, 'sourceLinke',['class'=>'dfinput','placeholder'=>'输入文章链接地址','id'=>'sourceLinke'])?>
	<button class="btn getArticle-btn" >点击抓取</button>
	<div style="margin-left: 86px"><i style="    padding-left: 0px;">链接地址来源必须是人民网、新华网、中央社会主义和四川组工网，且地址必须有效，以http://或https://开始;</i></div></li>
	
	<li><label>文章来源</label><?php echo Html::activeTextInput($model, 'source',['class'=>'dfinput','id'=>'source'])?><i></i></li>
	
    <li><label>文章内容<b>*</b></label>
    	<?php echo Html::activeHiddenInput($model, 'contentCount',['id'=>'contentCount'])?>
    	<div style="margin-left:86px;width:900px;height:500px" id="content" name="Article[content]"></div>
    </li>
    
    <li><label>备&nbsp;&nbsp;注</label><?php echo Html::activeTextarea($model, 'remarks',['class'=>'textinput'])?><i></i></li>
    
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
$content = $model->content;
$js = <<<JS
$(document).on('click','.getArticle-btn',function(){
    var _this = $(this);
	var sourceLinke = $('#sourceLinke').val();
	if(sourceLinke == ''){
		alert('请输入链接地址');return;
	}
	if(!checkUrl(sourceLinke)){
		alert('链接地址无效');return;
	}
    _this.attr('disabled',true);
    $.get('$url',{sourceLinke:encodeURI(sourceLinke)},function(res){
        console.log(res);
        if(res && res.success){
            ue.setContent(res.data);
            $("#source").val(res.source);
        }
    })
	
});
var ue = UE.getEditor('content', {
	serverUrl : '$uploadurl',
});
ue.addListener('contentChange',function(){
    $('#contentCount').val(ue.getContentTxt().length)
})
 ue.ready(function() {
    ue.setContent('$content');
    var len = ue.getContentTxt().length;
    $('#contentCount').val(len);
});

$(document).on('change','#isPublish',function(){
    var val = $(this).val();
    if(val == 'userDefined'){
        $('.publishTimeByUser').show();
    }else{
        $('.publishTimeByUser').hide();
    }
})

//时间选择框
var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
$('#publishTime').datetimepicker({
      //lang:"zh", //语言选择中文 注：旧版本 新版方法：$.datetimepicker.setLocale('ch');
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      minDate : now,
      minTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

JS;
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.config.js');
AppAsset::addScript($this, '/admin/js/ueditor/ueditor.all.min.js');
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>