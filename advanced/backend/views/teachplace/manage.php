<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['teachplace/manage'])?>">教学点管理</a></li>
        <li><a href="<?php echo Url::to(['teachplace/manage'])?>">教学点列表</a></li>
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
        <li><label>教学点</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
        <li class="click"><span><img src="/admin/images/t01.png" /></span>添加</li>
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
            <th>教学点</th>
            <th>详细地址</th>
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
            <td><?php echo $val['text'];?></td>
            <td><?php echo $val['address'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['teachplace/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['teachplace/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS

CSS;
$js = <<<JS

JS;
$this->registerJs($js);
$this->registerCss($css);
?>