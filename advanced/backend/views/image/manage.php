<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">新闻系统</a></li>
    <li><a href="<?php echo Url::to(['image/manage'])?>">内容管理</a></li>
    <li><a href="<?php echo Url::to(['image/manage'])?>">图片列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    <?php echo Html::beginForm(Url::to(['image/manage']),'get');?>
    	<ul class="seachform">
    		<li><label>图片标题</label><?php echo Html::activeTextInput($model, 'search[title]',['class'=>'scinput'])?></li>
	        <li>
	            <label>分类</label>  
	            <div class="vocation">
	                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
	            </div>
	        </li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li><a href="<?php echo Url::to(['image/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        	<li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        </ul>
        <?php echo Html::endForm();?>
        
<!--         <ul class="toolbar1"> -->
<!--         <li><span><img src="/admin/images/t05.png" /></span>设置</li> -->
<!--         </ul> -->
    
    </div>
    
    <table class="imgtable">
    
	    <thead>
		    <tr>
		    <th><input name="" type="checkbox" class="s-all" /></th>
		    <th width="300px;">图片</th>
		    <th>图片标题</th>
		    <th>图片分类</th>
		    <th>链接地址</th>
		    <th>提供者</th>
		    <th>院领导</th>
		    <th>创建时间</th>
            <th>修改时间</th>
		    <th>操作</th>
		    </tr>
	    </thead>
    
	    <tbody>
	    	<?php foreach ($list['data'] as $val):?>
		    <tr>
		    <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
		    <td class="imgtd"><img src="<?php echo $val['photo']?>" /></td>
		    <td><?php echo $val['title'];?></td>
		    <td><?php echo $val['categorys']['text'];?></td>
		    <td><?php echo $val['link'];?></td>
		    <td><?php echo $val['provider'];?></td>
		    <td><?php echo $val['leader'];?></td>
		    <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
		    <td>
		    <a href="<?php echo Url::to(['image/edit','id'=>$val['id']])?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Url::to(['image/del','id'=>$val['id']])?>">删除</a>
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
$js= <<<JS
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