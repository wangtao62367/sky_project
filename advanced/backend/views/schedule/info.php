<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use common\publics\MyHelper;
use yii\helpers\ArrayHelper;

$controller = Yii::$app->controller;
$param = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$param));

$this->title = '查看设置课表-'.$schedule->title.'【'.$schedule->gradeClass.'】';
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a></li>
        <li><a href="<?php echo $url?>"><?php echo $this->title?></a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm($url,'get');?>
	<ul class="seachform">
		<li><label>课程名称</label><?php echo Html::activeTextInput($model, 'search[curriculumText]',['class'=>'scinput'])?></li>
        <li><label>授课教师</label><?php echo Html::activeTextInput($model, 'search[teacherName]',['class'=>'scinput'])?></li>
        <li><label>授课地点</label><?php echo Html::activeTextInput($model, 'search[teachPlace]',['class'=>'scinput'])?></li>
        
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li class="click"><a href="<?php echo Url::to(['scheduletable/add','sid'=>$schedule->id])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" value="" /></th>
            <th>课程名称</th>
            <th>授课时间</th>
            <th>授课地点</th>
            <th>授课教师</th>
            <th>创建时间</th>
            <th>编辑时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" type="checkbox" class="item" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['curriculumText'];?></td>
            <td><?php echo $val['lessonDate'] . ' ' . $val['lessonStartTime'] . '~' .$val['lessonEndTime'];?></td>
            <td><?php echo $val['teachPlace'] ;?></td>
            <td><?php echo $val['teacherName'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['scheduletable/edit','id'=>$val['id'],'sid'=>$schedule->id]);?>" class="tablelink">编辑</a>  
            <a href="<?php echo Url::to(['scheduletable/del','id'=>$val['id'],'sid'=>$schedule->id]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
        
        <?php if(empty($list['data'])):?>
        <tr>
        	<td colspan="8" style="text-align: center">还未设置课程</td>
        </tr>
        <?php endif;?>
    </tbody>

</table>

<div class="pagination">
    <div style="float: left"><span>总共有 <?php echo $list['count'];?> 条数据</span></div>
    <!-- 这里显示分页 -->
    <div id="Pagination"></div>
</div>

<?php 
$css = <<<CSS
.schedule-table{margin-top:30px;}
.schedule-table table{width:600px;display:table;margin:0 auto;}

CSS;
$batchDelUrl = Url::to(['scheduletable/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['scheduletable/export','sid'=>$schedule->id]);
$js = <<<JS
//快速发布
$(document).on('click','.publishBtn',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        if(res){
            $(document).find('body').append(res);
        }
    })
})
//批量删除
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
$(document).on('click','.excel-btn',function(){
    var form = $(this).parents('form')[0];
    $(form).attr('action','$exportUrl');
    $(form).submit();
});

JS;
$this->registerJs($js);
$this->registerCss($css);

?>