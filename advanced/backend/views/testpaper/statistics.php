<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\TestPaper;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));

$this->title = '统计查看-'.$paper['title']
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
        <li><label>用户账号</label><?php echo Html::activeTextInput($model, 'search[account]',['class'=>'scinput','placeholder'=>'用户账号'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <!-- <li><a href="javascript:;" class="excel-btn">导出</a></li> -->
    </ul>
    <?php echo Html::endForm();?>
</div>

<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、测试试卷可以重复答题进行测试，每次测试的答题标识不一样</li>
	</ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th>用户名（账号）</th>
            <th>答题标识</th>
            <th>正确数</th>
            <th>错误数</th>
            <th>答题正确率</th>
            <th>得分</th>
            <th>答题花费时间</th>
            <th>答题时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><?php echo $val['account'];?></td>
            <td><?php echo $val['anwserMark'];?></td>
            <td><?php echo $val['rightCount'];?></td>
            <td><?php echo $val['wrongCount'];?></td>
            <td><?php echo round( $val['rightCount']/($val['rightCount']+$val['wrongCount']),3) * 100;?>%</td>
            <td><?php echo $val['rightScores'];?></td>
            <td><?php echo date('H:i:s',$val['answerTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            	<a href="<?php echo Url::to(['/testpaper/answer-info','paperid'=>$val['paperId'],'userid'=>$val['userId'],'mark'=>$val['anwserMark']]);?>" title="查看答题详情">答题详情</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<div class="pagination">
    <div style="float: left"><span>总共有 <?php echo $list['count'];?> 条数据</span></div>
    <!-- 这里显示分页 -->
    <div id="Pagination"></div>
</div>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['testpaper/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();

$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
})

initPagination({
	el : "#Pagination",
	count : $count,
	curPage : $curPage,
	pageSize : $pageSize,
    uri : '$uri'
});

JS;
$this->registerJs($js);
$this->registerCss($css);
?>