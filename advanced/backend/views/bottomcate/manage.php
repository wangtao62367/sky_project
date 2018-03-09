<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['bottomcate/manage'])?>">底部链接分类管理</a></li>
        <li><a href="<?php echo Url::to(['bottomcate/manage'])?>">底部链接分类列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['bottomcate/manage']),'get');?>
	<ul class="seachform">
        <li><label>底部链接分类姓名</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput'])?></li>
        
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['bottomcate/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<div class="warnning" style="margin-top: 15px">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、底部链接分类进行修改或者编辑后，必须到官员员系统->基础配置->清除缓存 进行缓存清理，否则首页无法显示</li>
		<li>2、排序值越小排在越靠前 </li>
	</ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>链接分类姓名</th>
            <th>分类标识</th>
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
            <td><?php echo $val['codeDesc'];?></td>
            <td><?php echo $val['code'];?></td>
            <td><?php echo $val['sorts'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            	<a href="<?php echo Url::to(['bottomcate/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            	<a href="<?php echo Url::to(['bottomcate/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['bottomcate/batchdel']);
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