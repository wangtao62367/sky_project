<?php 
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use common\models\QuestCategory;

$this->title= '在线试卷测评-'.$info['title'];
//var_dump($info);exit();
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<?php echo $this->title;?></p>
<div class="content">
	<div class="quest-paper left">
        <h2 class="quest-title"><?php echo $info['title'];?></h2>
        <div class="quest-mark">卷面总分：<?php echo array_sum(array_column($info['testpaperquestions'], 'score'));?>分（答题时间：<?php echo $info['timeToAnswer'];?> 分钟）</div>
        <div class="quest-list">
            <?php foreach ($info['testpaperquestions'] as $quest):?>
            <div class="quest-item" data-questcate = "<?php echo $quest['questions']['cate'];?>" data-questid="<?php echo $quest['questions']['id']; ?>">
            	<div class="quest-count left">
            		<p>第<?php echo $quest['sorts'];?>题</p>
            		<p><?php echo QuestCategory::getQuestCateText($quest['questions']['cate']);?></p>
            		<i><?php echo $quest['score'];?>分</i>
            	</div>
            	<div class="quest-txt left">
            		<p><?php echo $quest['questions']['title'];?>：</p>
            		<div>
            			<?php foreach ($quest['questions']['options'] as $k=>$opt):?>
            			<div class="right-anwswer" >
            		    		<label class="rightAnswer--label" data-questtype="<?php echo $quest['questions']['cate'];?>">
            				        <input class="rightAnswer--radio" data-questopt = "<?php echo MyHelper::getOpt($k,$quest['questions']['cate']);?>" value="<?php echo pow(2, $opt['sorts']+1)?>" type="checkbox" name="rightAnswer-checkbox2">
            				        <font class="rightAnswer--checkbox rightAnswer--radioInput"></font><?php echo MyHelper::getOpt($k,$quest['questions']['cate']);?>.&nbsp;&nbsp;<?php echo $opt['opt'];?>
            				    </label>
            		    </div>
            		    <?php endforeach;?>
            		</div>
            	</div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="quest-answer left">
    	<button class="btn btn-answer btn-answer-start" id="answerStart">开始答题</button>
    	<button class="btn btn-answer btn-answer-submit" style="display: none" id="answerSubmit">提交答案</button>
    	<p>截止答题时间：<span class="answer_time" id="answer_time"></span></p>
    </div>
</div>
<?php

AppAsset::addCss($this, '/front/css/questionAnswer.css');
AppAsset::addCss($this, '/front/js/dialog/dialog.css');
AppAsset::addScript($this, '/front/js/dialog/jquery.dialog.js');

$answerTime = $info['timeToAnswer'] * 60;
$paperId = $info['id'];
$submitAnswerUrl = Url::to(['student/submit-answer']);

$userCenter = Url::to(['user/center']);
$js = <<<JS
var answerTime = $answerTime;
var answerTotalTime = $answerTime;
var myInterval;
$('#answer_time').text(common.sec_to_time(answerTime));


$(document).on('click','.rightAnswer--label',function(e){
    if(answerTime == 0 || $('#answerStart').is(":visible")  ){
        return false;
    }
	var optionsTypeVal = $(this).data('questtype');
	if(optionsTypeVal == 'radio' || optionsTypeVal == 'trueOrfalse' ){
		$(this).parent().parent().find('input[type=checkbox]:checked').prop('checked',false);
		$(this).find('input[type=checkbox]').prop('checked',true);
	};
});
//开始答题
$('#answerStart').click(function(){
    intervalAnswer();
    $(this).hide();
    $('#answerSubmit').show();
})


$("#answerSubmit").click(function(){
	clearInterval(myInterval);
	if(answerTime > 0 ){
		var answerTimeTxt = common.sec_to_time(answerTime);
		d.init('提示信息','<img class="wenhao" alt="" src="/front/img/news/wenhao.jpg" ><p class="query-submit">剩余答题时间：'+answerTimeTxt+'，确认提交答案？</p>',true,submitAnswer);
	}else{
		submitAnswer();
	}
});

function intervalAnswer(){
	myInterval = setInterval(function(){
        answerTime --;
        $('#answer_time').text(common.sec_to_time(answerTime));
        if(answerTime == 0){
            clearInterval(myInterval);
            //时间截止
            d.init('提示信息','<img class="wenhao" alt="" src="/front/img/news/wenhao.jpg" ><p class="query-submit">答题结束，确认提交答案？</p>',true,submitAnswer);
        }
    },1000);
}

//提交答案
function submitAnswer(isTips){
	isTips = isTips || false;
    var paperId = $paperId;
    var userAnswers = [];
    var userUnAnswers = [];
    var questItems = $('.quest-item');
    questItems.each(function(index,el){
        var questcate = $(this).data('questcate');
        var questid = $(this).data('questid');
        var userAnswer = 0;
        var userOpts = [];
        //获取用户答题结果
        var userSelected = $(this).find('input[type=checkbox]:checked');
        //记录未答题的试题
        if(userSelected.length == 0){
            userUnAnswers.push(index+1);
        }
        userSelected.each(function(){
            userAnswer += parseInt($(this).val());
            userOpts.push($(this).data('questopt'));
        });
        userAnswers.push({
            questId : questid,
            questcate : questcate,
            userAnswer  : userAnswer,
            userAnswerOpt : userOpts
        });
    })
    //提交答案
    $.post('$submitAnswerUrl',{paperId:paperId,userAnsers:userAnswers,answerTime:(answerTotalTime-answerTime)},function(res){
        if(res == 1){
			$(".tip").remove();
			window.location.href = '$userCenter';
		};
    });
}
JS;

$this->registerJs($js);
?>