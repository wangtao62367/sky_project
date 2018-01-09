<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['article/articles'])?>">文章管理</a></li>
    </ul>
</div>

<div class="rightinfo">
<!-- 	<div class="tools">
		<ul class="toolbar">
            <li class="click"><span><img src="/admin/images/t01.png" /></span>添加</li>
            <li class="click"><span><img src="/admin/images/t02.png" /></span>修改</li>
            <li><span><img src="/admin/images/t03.png" /></span>删除</li>
            <li><span><img src="/admin/images/t04.png" /></span>统计</li>
        </ul>
            
            
        <ul class="toolbar1">
            <li><span><img src="/admin/images/t05.png" /></span>设置</li>
        </ul>
	</div> -->
	<?php echo Html::beginForm(Url::to(['article/articles']),'get');?>
	<ul class="seachform">
        <li><label>主题/作者</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput'])?></li>
        <li>
            <label>分类</label>  
            <div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li>
            <label>是否发布</label>  
            <div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isPublish]', ['0'=>'未发布','1'=>'已发布'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['article/create'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" /></th>
            <th>序号<i class="sort"><img src="/admin/images/px.gif" /></i></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th>图片数</th>
            <th>预览数</th>
            <th>发布</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" type="checkbox" class="item" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['id'];?></td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['author'];?></td>
            <td><?php echo $val['categorys']['text'];?></td>
            <td><?php echo $val['imgCount'] ;?> </td>
            <td><?php echo $val['readCount'];?></td>
            <td><?php echo $val['isPublish'] == 0 ?'未发布' : '已发布';?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            	<a href="<?php echo Url::to(['article/edit','id'=>$val['id']])?>" class="tablelink">编辑</a>    
             	<a href="<?php echo Url::to(['article/del','id'=>$val['id']])?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
<?php 
$css = <<<CSS
.article-tags{padding:3px 8px;border:0;border-radius: 5px;background:#e4e4e0;display: inline;}
CSS;
$batchDelUrl = Url::to(['article/batchdel']);
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