<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['download/manage'])?>">下载列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['download/manage']),'get');?>
	<ul class="seachform">
        <li><label>文件名称</label><?php echo Html::activeTextInput($model, 'search[descr]',['class'=>'scinput'])?></li>
        <li><label>文件类型</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['download/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>文件名称</th>
            <th>链接地址</th>
            <th>文件类型</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['descr'];?></td>
            <td><?php echo $val['uri'];?></td>
            <td><?php echo $val['categoryId'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['download/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['download/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['download/batchdel']);
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