<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;

$controller = Yii::$app->controller;
$parames = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$parames));

$this->title = '统计查看-'.$info['title'];
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务管理系统</a></li>
        <li><a href="<?php echo Url::to(['naire/manage'])?>">调查管理</a></li>
        <li><a href="<?php echo $url;?>"><?php echo $this->title;?></a></li>
    </ul>
</div>

<div class="statistics-box">
<h2><?php echo $info['title'];?></h2>
<p style="text-align: center;">(参与投票人数：<?php echo $count;?> 人)</p>
<div class="marks">
备注：
<?php echo $info['marks'] ? $info['marks'] : '无';?>
</div>
<ul class="votes-box">
  <?php foreach ($info['votes'] as $k=>$vote):?>
  <li>
  		<h4><?php echo $k+1;?>、（<?php echo QuestCategory::getQuestCateText($vote['selectType']);?> ）<?php echo $vote['subject']?></h4>
  		<ul class="opts-box">
  			<?php foreach ($vote['voteoptions'] as $i=>$opt):?>
  			<li><div class="left opt-subject"><?php echo MyHelper::getOpt($i,$vote['selectType']);?> 、<?php echo $opt['text']?></div>
  			<div class="left votes-counts-progress">
      			<span class="progress" style="width: <?php echo 300*($opt['counts']/$vote['voteCounts']) . 'px;'?>;background:#<?php echo Yii::$app->params['voteoptions.color'][$i];?>"></span>
      			<span class="opt-persent"><?php echo round(($opt['counts']/$vote['voteCounts'])*100,1);?>%</span>
  			</div></li>
  			<?php endforeach;?>
  		</ul>
  </li>
  <?php endforeach;?>
</ul>
</div>

<?php 
$css = <<<CSS
.left {float:left;}
.statistics-box{width:98%;margin:0 auto;max-width:960px;margin-top:30px;border:1px solid #d4d1d1;border-radius: 5px;padding:20px 10px;}
.marks{margin:10px 0px}

.statistics-box h2{text-align:center;font-size: 30px;}
.votes-box{max-height:700px;overflow:hidden;position: relative;overflow-y: scroll;padding-top:20px;}

.votes-box .opts-box{margin-left:10px;margin-top:10px;overflow:hidden;position: relative;}
.votes-box .opts-box li{margin-bottom:15px;overflow:hidden;position: relative;}
.votes-box .opts-box .opt-subject{width:580px;margin-right:10px;}
.votes-counts-progress{width:340px;}
.votes-counts-progress span{display:inline-block;}
.votes-counts-progress .progress{height: 19px;border-radius: 5px;}
.opt-persent{width:35px;float:right;}

CSS;
$this->registerCss($css);
?>
