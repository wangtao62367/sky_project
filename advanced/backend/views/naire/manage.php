<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['naire/manage'])?>">调查管理</a></li>
        <li><a href="<?php echo Url::to(['naire/manage'])?>">问卷列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm();?>
	<ul class="seachform">
        <li><label>问卷主题</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput','placeholder'=>'问卷主题'])?></li>
        <li><label>是否发布</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isPublish]', ['0'=>'未发布','1'=>'已发布'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['naire/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>问卷调查主题</th>
            <th>调查题数</th>
            <th>发布状态</th>
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
            <td><?php echo $val['voteCount'];?></td>
            <td><?php echo $val['isPublish'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['naire/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['naire/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['naire/batchdel']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>