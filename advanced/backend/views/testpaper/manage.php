<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\TestPaper;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷管理</a></li>
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['testpaper/manage']),'get');?>
	<ul class="seachform">
        <li><label>试卷主题</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput','placeholder'=>'试卷主题'])?></li>
        <li><label>试卷来源</label><?php echo Html::activeTextInput($model, 'search[from]',['class'=>'scinput','placeholder'=>'试卷来源'])?></li>
        <li><label>所属班级</label><?php echo Html::activeTextInput($model, 'search[gradeClass]',['class'=>'scinput','placeholder'=>'所属班级'])?></li>
        <li><label>是否发布</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isPublish]', ['0'=>'未发布','1'=>'已发布'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['testpaper/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <!-- <li><a href="javascript:;" class="excel-btn">导出</a></li> -->
    </ul>
    <?php echo Html::endForm();?>
</div>
<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、测试试卷可以重复答题进行测试练习。</li>
		<li>2、已发布的测试试卷谨慎编辑操作，否则引起试卷答题统计数据不准确。</li>
	</ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>试卷主题</th>
            <th>作答时间(分钟)</th>
            <th>作答班级</th>
            <th>试题总数</th>
            <th>单选题数</th>
            <th>多选题数</th>
            <th>判断题数</th>
            <th>其他题数</th>
            <th>发布状态</th>
            <th>发布时间</th>
            <th>试卷来源</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['timeToAnswer'];?></td>
            <td><?php echo $val['gradeClass']['className'];?></td>
            <td><?php echo $val['questionCount'];?></td>
            <td><?php echo $val['radioCount'];?></td>
            <td><?php echo $val['multiCount'];?></td>
            <td><?php echo $val['t_fCount'];?></td>
            <td><?php echo $val['otherCount'];?></td>
            <td><?php echo $val['isPublish']==0?'未发布':'已发布';?></td>
            <td><?php echo MyHelper::timestampToDate($val['publishTime']);?></td>
            <td><?php echo $val['from'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
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