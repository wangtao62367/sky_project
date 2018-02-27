<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use backend\assets\AppAsset;
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">新闻系统</a></li>
    <li><a href="<?php echo Url::to(['carousel/manage'])?>">首页轮播管理</a></li>
    <li><a href="<?php echo Url::to(['carousel/manage'])?>">首页轮播列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    	<ul class="seachform">
    		<li></li>
        	<li><a href="<?php echo Url::to(['carousel/add'])?>" class="add-btn">添加</a></li>
        	<li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        </ul>
    </div>
    

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>轮播图</th>
            <th>轮播标题</th>
            <th>链接地址</th>
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
            <td>
            	<img alt="" src="<?php echo $val['img'];?>" width="400px" height="200px">
            </td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['link'];?></td>
            <td><?php echo $val['sorts'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['carousel/edit','id'=>$val['id']]);?>" class="tablelink"> 编辑 </a>
            <a href="<?php echo Url::to(['carousel/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
</div>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['carousel/batchdel']);

$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
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
JS;
$this->registerJs($js);
$this->registerCss($css);
?>