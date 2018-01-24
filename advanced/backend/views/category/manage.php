<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['category/manage'])?>">分类管理</a></li>
        <li><a href="<?php echo Url::to(['category/manage'])?>">分类列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['category/manage']),'get');?>
	<ul class="seachform">
        <li><label>分类名称</label><?php echo Html::activeTextInput($model, 'search[text]',['class'=>'scinput'])?></li>
        <li><label>所属类型</label>
        	<div class="vocation">
        		<?php echo Html::activeDropDownList($model, 'search[type]', Category::$type_arr,['prompt'=>'请选择','class'=>'sky-select'])?>
        	</div>
        </li>
        <li><label>所属板块</label>
        	<div class="vocation">
        		<?php echo Html::activeDropDownList($model, 'search[parentId]', ArrayHelper::map($parentCates,'id','codeDesc'),['prompt'=>'请选择','class'=>'sky-select'])?>
        	</div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['category/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        <li><a href="javascript:;" class="export-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>分类名称</th>
            <th>所属板块</th>
            <th>所属类型</th>
            <th>分类描述</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['text'];?></td>
            <td><?php echo $val['codeDesc'];?></td>
            <td><?php echo Category::$type_arr[$val['type']] ;?></td>
            <td><?php echo $val['descr'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['category/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <?php if($val['isBase'] != 1):?>
            <a href="<?php echo Url::to(['category/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            <?php endif;?>
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
$batchDelUrl = Url::to(['category/batchdel']);

$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['category/export']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
});

initPagination({
	el : "#Pagination",
	count : $count,
	curPage : $curPage,
	pageSize : $pageSize,
    uri : '$uri'
});

//导出
$(document).on('click','.export-btn',function(){
    var form = $(this).parents('form')[0];
    $(form).attr('action','$exportUrl');
    $(form).submit();
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>