<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

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
	<ul class="seachform">
        <li><label>主题</label><?php echo Html::activeTextInput($model, 'search[title]',['class'=>'scinput'])?></li>
        <li>
            <label>指派</label>  
            <div class="vocation">
                <select class="select3">
                    <option>全部</option>
                    <option>其他</option>
                </select>
            </div>
        </li>
        
        <li>
            <label>重点客户</label>  
            <div class="vocation">
                <select class="select3">
                    <option>全部</option>
                    <option>其他</option>
                </select>
            </div>
        </li>
        
        <li>
        	<label>客户状态</label>  
            <div class="vocation">
                <select class="select3">
                    <option>全部</option>
                    <option>其他</option>
                </select>
            </div>
        </li>
        <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
        <li><a href="<?php echo Url::to(['article/create'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li class="click"><span><img src="/admin/images/t02.png" /></span>修改</li>
        <li><span><img src="/admin/images/t03.png" /></span>删除</li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" /></th>
            <th>序号<i class="sort"><img src="/admin/images/px.gif" /></i></th>
            <th>标题</th>
            <th>作者</th>
            <th>标签</th>
            <th>分类</th>
            <th>预览数</th>
            <th>是否发布</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['id'];?></td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['author'];?></td>
            <td>
            	<?php foreach ($val['articletags'] as $tag):?>
            		<span class="article-tags"><?php echo  $tag['tags']['tagName'];?></span>
            	<?php endforeach;?>
            </td>
            <td><?php echo $val['categorys']['text']?></td>
            <td><?php echo $val['readCount'];?></td>
            <td><?php echo $val['isPublish'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS
.article-tags{padding:3px 8px;border:0;border-radius: 5px;background:#e4e4e0;display: inline;}
CSS;
$js = <<<JS
$(document).ready(function(e) {
    $(".select1").uedSelect({
		width : 345			  
	});
	$(".select2").uedSelect({
		width : 167  
	});
	$(".select3").uedSelect({
		width : 100
	});
});
JS;
$this->registerJs($js);
$this->registerCss($css);
?>