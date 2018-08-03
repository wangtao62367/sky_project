<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;


?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻管理系统</a></li>
        <li><a href="<?php echo Url::to(['famous-teacher/list'])?>">名师堂</a></li>
        <li><a href="<?php echo Url::to(['famous-teacher/list'])?>">名师列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['famous-teacher/list']),'get');?>
	<ul class="seachform">
        <li><label>姓名</label><?php echo Html::activeTextInput($model, 'search[name]',['class'=>'scinput'])?></li>
        <li><label>授课内容</label><?php echo Html::activeTextInput($model, 'search[teach]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['famous-teacher/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" /></th>
            <th>头像</th>
            <th>姓名</th>
            <th>授课内容</th>
            <th>排序</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><img alt="" src="<?php echo $val['avater'];?>" width="100" height="150px"/></td>
            <td><?php echo $val['name'];?></td>
            <td><?php echo $val['teach'];?></td>
            <td><?php echo $val['sorts'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['famous-teacher/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>      
            <a href="<?php echo Url::to(['famous-teacher/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['famous-teacher/batchdel']);
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