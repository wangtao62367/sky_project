<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\TestPaper;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;
use common\models\QuestCategory;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));

$this->title = '查看答题详情-'.$testPaper['title']
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $this->title;?></a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm($url,'get');?>
	<ul class="seachform">
        <li><a href="<?php echo $url . '&handle=excel'?>" class="excel-btn">导出</a></li>
        <li><a href="javascript:;" class="print-btn">打印</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<div id="printContent"  style="margin-top:1px">
	<h2 style="width: 794px;text-align:center;margin:0 auto;font-size:20px;font-weight:700;"><?php echo $testPaper->title;?></h2>
	<div style="width: 794px;text-align:center;margin:0 auto;">
		卷面总分：<?php echo array_sum(array_column($testPaper['testpaperquestions'], 'score'));?>分（答题时间：<?php echo $testPaper['timeToAnswer'];?> 分钟）
	</div>
	<div style="width: 794px;text-align:center;margin:0 auto;margin-top:30px;">
		<label>姓名：</label><span style="display:inline;text-decoration: underline;font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $trueName;?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<label>日期：</label><span style="display:inline;text-decoration: underline;font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$paperstatics['createTime']);?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<label>用时：</label><span style="display:inline;text-decoration: underline;font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ceil($paperstatics['answerTime']/60);?>分钟&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<label>得分：</label><span style="display:inline;text-decoration: underline;font-size:20px;color:red">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $paperstatics['rightScores'];?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
	</div>
    <table border="0" cellpadding="0" cellspacing="0" style="width:794px;height:auto;;margin-left:auto; margin-right:auto; margin-top:10px; margin-bottom:10px; background:#ffffff;border:1px solid #000;">
    	<tr>
    		<td style="text-align:center;border-right:1px solid #000;border-bottom:1px solid #000;font-size:18px;">题序</td>
    		<td style="text-align:center;border-right:1px solid #000;border-bottom:1px solid #000;font-size:18px;">内容</td>
    		<td style="text-align:center;border-bottom:1px solid #000;">答案</td>
    	</tr>
    	<?php foreach ($answers as $v):?>
    	<tr>
    		<td style="padding: 20px;border-right:1px solid #000;">
    			<p>第 <?php echo $v->paperquestion->sorts;?> 题</p>
    			<p><?php echo QuestCategory::getQuestCateText($v->question->cate);?></p>
    			<p>（<?php echo $v->paperquestion->score;?>分）</p>
    		</td>
    		<td style="padding:20px;border-right:1px solid #000;">
    			<p><?php echo $v->question->title;?>：</p>
    			<p style="text-align: right;">
        			<?php if($v->isRight == 1):?>
        			<i style="color: #0bf314;font-size:18px;">✔</i>
        			<?php else :?>
        			<i style="color: red;font-size:18px;">✘</i>
        			<?php endif;?>
    			</p>
    			<?php $userAnswerOpt = unserialize($v->userAnswerOpt); ?>
    			<?php foreach ($v->question->options as $k=>$opt):?>
    			<div style="margin-bottom: 8px;">
        			<label class="rightAnswer--label" data-questtype="radio">
        		        <input class="rightAnswer--radio" <?php echo $userAnswerOpt && in_array(MyHelper::getOpt($k,$v->question->cate), $userAnswerOpt) ? 'checked':''?> disabled type="checkbox" name="rightAnswer-checkbox2">
        		        <font class="rightAnswer--checkbox rightAnswer--radioInput"></font><?php echo MyHelper::getOpt($k,$v->question->cate);?>.&nbsp;&nbsp;<?php echo $opt->opt;?> 
    		        </label>
		        </div>
		        <?php endforeach;?>
    		</td>
    		<td style="padding: 20px;"><?php echo implode('、', json_decode($v->question->answerOpt,true));?></td>
    	</tr>
    	<?php endforeach;?>
    </table>
</div>

<?php 
AppAsset::addScript($this, '/admin/js/jquery.PrintArea.js');
$css = <<<CSS
.seachform li {
    float: right;
    margin: 5px 15px 5px 0px;
}

.rightAnswer--label{/*margin:20px 20px 0 0;*/display:inline-block}
.rightAnswer--radio{display:none}
.rightAnswer--radioInput{background-color:#fff;border:1px solid rgba(0,0,0,0.15);border-radius:100%;display:inline-block;height:16px;margin-right:10px;margin-top:-1px;vertical-align:middle;width:16px;line-height:1}
.rightAnswer--radio:checked + .rightAnswer--radioInput:after{background-color:#57ad68;border-radius:100%;content:"";display:inline-block;height:12px;margin:2px;width:12px}
.rightAnswer--checkbox.rightAnswer--radioInput,.rightAnswer--radio:checked + .rightAnswer--checkbox.rightAnswer--radioInput:after{border-radius:0}

CSS;
$js = <<<JS
$(document).on('click','.print-btn',function(){
    $("div#printContent").printArea(); 
})
function printWorkorder(){
	//pagesetup_null();
	$("div#printContent").printArea(); 
}

JS;
$this->registerJs($js);
$this->registerCss($css);
?>