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
    <li><a href="#">网站管理系统</a></li>
    <li><a href="<?php echo Url::to(['educationbase/manage'])?>">教育基地管理</a></li>
    <li><a href="<?php echo Url::to(['educationbase/manage'])?>">教育基地列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    <?php echo Html::beginForm(Url::to(['educationbase/manage']),'get');?>
    	<ul class="seachform">
    		<li><label>图片标题</label><?php echo Html::activeTextInput($model, 'search[kewords]',['class'=>'scinput'])?></li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li class="click"><a href="<?php echo Url::to(['educationbase/add'])?>" class="add-btn">添加</a></li>
        	<li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        </ul>
        <?php echo Html::endForm();?>
    
    </div>
    
    <table class="imgtable">
    
	    <thead>
		    <tr>
		    <th><input name="" type="checkbox" class="s-all" /></th>
		    <th width="300px;">基地图片</th>
		    <th>基地名称</th>
		    <th>链接地址</th>
		    <th>创建时间</th>
            <th>修改时间</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    	<?php foreach ($list['data'] as $val):?>
		    <tr>
		    <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
		    <td class="imgtd"><img src="<?php echo $val['baseImg']?>" /></td>
		    <td><?php echo $val['baseName'];?></td>
		    <td><?php echo $val['link'];?></td>
		    <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
		    <td class="handle-box">
		    <a href="<?php echo Url::to(['educationbase/edit','id'=>$val['id']])?>">编辑</a>
		    <a href="<?php echo Url::to(['educationbase/del','id'=>$val['id']])?>">删除</a>
		    </td>
		    </tr>
		    <?php endforeach;?>
	    
	    </tbody>
    
    </table>
	<div class="pagination">
	    <div style="float: left">总共有 <?php echo $list['count'];?> 条数据</div>
	    <!-- 这里显示分页 -->
	    <div id="Pagination"></div>
	</div>
</div>
<?php 
$uri = Yii::$app->request->getUrl();
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$batchDelUrl = Url::to(['educationbase/batchdel']);
$js= <<<JS
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
?>