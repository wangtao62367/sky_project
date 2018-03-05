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
	<?php echo Html::beginForm(Url::to(['testpaper/manage']),'get');?>
	<ul class="seachform">
        <li><label>用户账号</label><?php echo Html::activeTextInput($model, 'search[account]',['class'=>'scinput','placeholder'=>'试卷主题'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['testpaper/add'])?>" class="add-btn">添加</a></li>
        <!-- <li><a href="javascript:;" class="excel-btn">导出</a></li> -->
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th>答题人账号</th>
            <th>答题标识</th>
            <th>正确数</th>
            <th>错误数</th>
            <th>答题正确率</th>
            <th>得分</th>
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
            <td><?php echo $val['rightCount']/($val['rightCount']+$val['wrongCount']);?></td>
            <td><?php echo $val['rightScores'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['testpaper/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>    
            <a href="<?php echo Url::to(['testpaper/statistics','id'=>$val['id']]);?>" class="tablelink">统计查看</a>  
            <a href="<?php echo Url::to(['testpaper/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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