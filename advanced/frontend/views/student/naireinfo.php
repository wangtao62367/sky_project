<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\publics\MyHelper;

$this->title= '查看调查信息-'.$info['title'];
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<?php echo $this->title;?></p>
<div class="content">

<h2 class="title"><?php echo $info['title'];?></h2>

<?php foreach ($info['votes'] as $k=>$vote):?>
<div class="votes">
	<p> <?php echo $k+1;?> 、<?php echo $vote['subject'];?></p>
	<div class="votesopt-box">
		<?php foreach ($vote['voteoptions'] as $i=>$opt):?>
		<div class="opt-item">
			<div class="left item-text"><?php echo MyHelper::getOpt($i,$vote['selectType']);?>、<?php echo $opt['text'];?></div>
			<div class="left item-counts">
			<span class="progress">
				<span style="width: <?php echo 450*($opt['counts']/$vote['voteCounts']) . 'px;'?>;background:#<?php echo Yii::$app->params['voteoptions.color'][$i];?>"></span>
			</span>
			<span class="counts-persent"><?php echo round(($opt['counts']/$vote['voteCounts'])*100,1);?>%</span>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
<?php endforeach;?>

</div>

<?php 
AppAsset::addCss($this, '/front/css/naireinfo.css');
?>