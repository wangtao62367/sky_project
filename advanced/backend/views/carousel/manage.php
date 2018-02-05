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
    <li><a href="<?php echo Url::to(['carousel/manage'])?>">内容管理</a></li>
    <li><a href="<?php echo Url::to(['carousel/manage'])?>">图片列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    	<ul class="seachform">
        	<li class="click"><a href="<?php echo Url::to(['carousel/add'])?>" class="add-btn">添加</a></li>
        	<li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
        </ul>
    </div>
    
    <table class="imgtable">
    
	    <thead>
		    <tr>
		    <th><input name="" type="checkbox" class="s-all" /></th>
		    <th width="300px;">轮播图</th>
		    <th>链接地址</th>
		    <th>创建时间</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    	<?php foreach ($list['data'] as $val):?>
		    <tr>
		    <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
		    <td class="imgtd"><img src="<?php echo $val['img']?>" /></td>
		    <td><?php echo $val['link'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
		    <td class="handle-box">
		     <a href="<?php echo Url::to(['carousel/edit','id'=>$val['id']])?>">编辑</a>
		     <a href="<?php echo Url::to(['carousel/del','id'=>$val['id']])?>">删除</a>
		    </td>
		    </tr>
		    <?php endforeach;?>
	    
	    </tbody>
    
    </table>
</div>
<?php 
$batchDelUrl = Url::to(['image/batchdel']);
$js= <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
});

JS;
$this->registerJs($js);
?>