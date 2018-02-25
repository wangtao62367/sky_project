<?php 
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use common\models\QuestCategory;

$this->title= '在线调查-'.$info['title'];
//var_dump($info);exit();
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<?php echo $this->title;?></p>
<div class="content">
	<div class="quest-paper left">
        <h2 class="quest-title"><?php echo $info['title'];?></h2>
        <div class="quest-mark"></div>
        <div class="quest-list">
            <?php foreach ($info['votes'] as $k=>$vote):?>
            <div class="quest-item" data-questcate = "<?php echo $vote['selectType'];?>" data-questid="<?php echo $vote['id']; ?>">
            	<div class="quest-count left">
            		<p>投票题    <?php echo $k+1;?></p>
            		<p>（<?php echo $vote['selectTypeText'];?>）</p>
            	</div>
            	<div class="quest-txt left">
            		<p><?php echo $vote['subject'];?>：</p>
            		<div>
            			<?php foreach ($vote['voteoptions'] as $k=>$opt):?>
            			<div class="right-anwswer" >
            		    		<label class="rightAnswer--label" data-questtype="<?php echo $vote['selectType'];?>">
            				        <input class="rightAnswer--radio" data-questopt = "<?php echo MyHelper::getOpt($k,$vote['selectType']);?>" value="<?php echo $opt['id']?>" type="checkbox" name="rightAnswer-checkbox2">
            				        <font class="rightAnswer--checkbox rightAnswer--radioInput"></font><?php echo MyHelper::getOpt($k,$vote['selectType']);?>.&nbsp;&nbsp;<?php echo $opt['text'];?>
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
    	<button class="btn btn-answer btn-answer-submit" id="answerSubmit">提交结果</button>
    	<p>备注：<span class="answer_time"><?php echo $info['marks'];?></span></p>
    </div>
</div>
<?php

AppAsset::addCss($this, '/front/css/questionAnswer.css');
AppAsset::addCss($this, '/front/js/dialog/dialog.css');
AppAsset::addScript($this, '/front/js/dialog/jquery.dialog.js');

$answerTime = 0;
$naireId = $info['id'];
$submitNaireUrl = Url::to(['student/submit-naire']);

$userCenter = Url::to(['user/center']);
$js = <<<JS

$(document).on('click','.rightAnswer--label',function(e){
	var optionsTypeVal = $(this).data('questtype');
	if(optionsTypeVal == 'radio' || optionsTypeVal == 'trueOrfalse' ){
		$(this).parent().parent().find('input[type=checkbox]:checked').prop('checked',false);
		$(this).find('input[type=checkbox]').prop('checked',true);
	};
});


$("#answerSubmit").click(function(){
	/* if(answerTime > 0 ){
		d.init('提示信息','<img class="wenhao" alt="" src="/front/img/news/wenhao.jpg" ><p class="query-submit">剩余答题时间：'+answerTimeTxt+'，确认提交答案？</p>',true,submitAnswer);
	}else{
		
	} */

	submitAnswer();
});

//提交答案
function submitAnswer(isTips){
	isTips = isTips || false;
	var naireId = $naireId;
    var userAnswers = [];
    var userUnAnswers = [];
    var questItems = $('.quest-item');
    questItems.each(function(index,el){
        var questcate = $(this).data('questcate');
        var questid = $(this).data('questid');
        var userAnswer = '';
        var userOpts = [];
        //获取用户答题结果
        var userSelected = $(this).find('input[type=checkbox]:checked');
        //记录未答题的试题
        if(userSelected.length == 0){
            userUnAnswers.push(index+1);
        }
        userSelected.each(function(){
            userAnswer += parseInt($(this).val()) + '-';
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
    $.post('$submitNaireUrl',{naireId:naireId,userAnswers:userAnswers},function(res){
        if(res == 1){
			$(".tip").remove();
			//window.location.href = '$userCenter';
		};
    });
}
JS;

$this->registerJs($js);
?>