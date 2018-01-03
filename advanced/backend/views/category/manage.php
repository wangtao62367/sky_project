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
	<?php echo Html::beginForm();?>
	<ul class="seachform">
        <li><label>分类名称</label><?php echo Html::activeTextInput($model, 'search[text]',['class'=>'scinput'])?></li>
        <li><label>所属类型</label>
        	<div class="vocation">
        		<?php echo Html::activeDropDownList($model, 'search[type]', Category::$type_arr,['prompt'=>'请选择','class'=>'select1'])?>
        	</div>
        </li>
        <li><label>所属板块</label>
        	<div class="vocation">
        		<?php echo Html::activeDropDownList($model, 'search[parentId]', ArrayHelper::map($parentCates,'id','codeDesc'),['prompt'=>'请选择','class'=>'select1'])?>
        	</div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['category/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
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
            <td>
            <a href="<?php echo Url::to(['category/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['category/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['category/batchdel']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
});
$(".select1").uedSelect({
		width : 100
	});
JS;
$this->registerJs($js);
$this->registerCss($css);
?>