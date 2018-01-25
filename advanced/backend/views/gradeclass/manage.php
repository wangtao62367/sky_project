<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['gradeclass/manage'])?>">班级管理</a></li>
        <li><a href="<?php echo Url::to(['gradeclass/manage'])?>">班级列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['gradeclass/manage']),'get');?>
	<ul class="seachform">
        <li><label>班级名称</label><?php echo Html::activeTextInput($model, 'search[className]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['gradeclass/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <li><a href="javascript:;" class="export-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" /></th>
            <th>班级名称</th>
            <th>班级人数</th>
            <th>报名时间</th>
            <th>开班时间</th>
            <th>教务员</th>
            <th>教务员电话</th>
            <th>媒体管理员</th>
            <th>媒体管理员电话</th>
            <th>开班出席领导</th>
            <th>结业出席领导</th>
            <th>本院教师任课节数</th>
            <th>邀约教师任课节数</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['className'];?></td>
            <td><?php echo $val['classSize'];?></td>
            <td><?php echo $val['joinStartDate'].'~'.$val['joinEndDate'];?></td>
            <td><?php echo $val['openClassTime'];?></td>
            <td><?php echo $val['eduAdmin'];?></td>
            <td><?php echo $val['eduAdminPhone'];?></td>
            <td><?php echo $val['mediaAdmin'];?></td>
            <td><?php echo $val['mediaAdminPhone'];?></td>
            <td><?php echo $val['openClassLeader'];?></td>
            <td><?php echo $val['closeClassLeader'];?></td>
            <td><?php echo $val['currentTeachs'];?></td>
            <td><?php echo $val['invitTeachs'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['gradeclass/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['gradeclass/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['gradeclass/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['gradeclass/export']);
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
//导出
$(document).on('click','.export-btn',function(){
    var form = $(this).parents('form')[0];
    $(form).attr('action','$exportUrl');
    $(form).submit();
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>