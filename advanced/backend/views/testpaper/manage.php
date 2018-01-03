<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷管理</a></li>
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<ul class="seachform">
        <li><label>试卷主题</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
        <li class="click"><a href="<?php echo Url::to(['testpaper/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>试卷主题</th>
            <th>试题数</th>
            <th>发布状态</th>
            <th>审核状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['questionCount'];?></td>
            <td><?php echo $val['isPublish'];?></td>
            <td><?php echo $val['verify'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['testpaper/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['testpaper/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['testpaper/batchdel']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>