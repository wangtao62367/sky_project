<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务系统</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表管理</a></li>
        <li><a href="<?php echo Url::to(['schedule/manage'])?>">课表列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<ul class="seachform">
        <li><label>课程名称</label><?php echo Html::activeTextInput($model, 'search[text]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
        <li><a href="<?php echo Url::to(['schedule/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
    </ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" /></th>
            <th>课程名称</th>
            <th>上课时间</th>
            <th>授课教师</th>
            <th>授课地点</th>
            <th>教学班级</th>
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
            <td><?php echo $val['curriculumText'];?></td>
            <td><?php echo $val['lessonDate'] . ' ' . $val['lessonTime'];?></td>
            <td><?php echo $val['teacherName'];?></td>
            <td><?php echo $val['teachplace']['text'];?></td>
            <td><?php echo $val['gradeclass']['className'];?></td>
            <td><?php echo $val['isPublish'] == 1 ? '已发布' : '未发布';?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['schedule/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a>     
            <a href="<?php echo Url::to(['schedule/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['schedule/batchdel']);
$js = <<<JS
$('.batchDel').click(function(){
    $('.batchDel').click(function(){
        batchDel('$batchDelUrl');
    })
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>