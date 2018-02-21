<?php 
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use common\models\QuestCategory;

$this->title= $info['title'];
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<?php echo $info['title']?></p>
<div class="content">
<h2 class="quest-title"><?php echo $info['title'];?></h2>
<div class="quest-mark">卷面总分：100分（剩余答题时间：<span>120</span> 分钟）</div>
<div>

<?php foreach ($info['testpaperquestions'] as $quest):?>
<div class="quest">
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
				        <input class="rightAnswer--radio" value="<?php echo pow(2, $opt['sorts'])?>" type="checkbox" name="rightAnswer-checkbox2">
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

<?php 
AppAsset::addCss($this, '/front/css/questionAnswer.css');

$js = <<<JS
$(document).on('click','.rightAnswer--label',function(e){
	var optionsTypeVal = $(this).data('questtype');
	if(optionsTypeVal == 'radio' || optionsTypeVal == 'trueOrfalse' ){
		$(this).parent().parent().find('input[type=checkbox]:checked').prop('checked',false);
		$(this).find('input[type=checkbox]').prop('checked',true);
	};
});

JS;

$this->registerJs($js);
?>