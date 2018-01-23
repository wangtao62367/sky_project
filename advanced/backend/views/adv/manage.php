<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Adv;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">网站管理系统</a></li>
        <li><a href="<?php echo Url::to(['adv/manage'])?>">广告列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<div class="tools">
    	<ul class="toolbar">
            <li><a href="<?php echo Url::to(['adv/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
            <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        </ul>
    </div>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>广告词</th>
            <th>广告图</th>
            <th>广告链接</th>
            <th>位置</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['advs'];?></td>
            <td class="imgtd">
            	<?php if(empty($val['imgs'])):?>
            		未设置
            	<?php else :?>
					<img width="100%" src="<?php echo $val['imgs']?>" />
            	<?php endif;?>

            </td>
            <td><?php echo $val['link'];?></td>
            <td><?php echo Adv::$position_text[$val['position']];?></td>
            <td><?php echo $val['status'] == 1 ? '开启' : '关闭' ;?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['adv/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>  
            <a href="<?php echo Url::to(['adv/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['user/batchdel']);
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