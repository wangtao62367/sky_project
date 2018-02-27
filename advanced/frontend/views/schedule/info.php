<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;

$this->title = '课表查询-' .$schedule->title.'【'.$schedule->gradeClass.'】';
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<?php echo $this->title;?></p>
<div class="content">
	
	<table class="schedule-table">
		<caption><?php echo $schedule->title.'【'.$schedule->gradeClass.'】';?></caption>
		<thead>
			<tr>
				<td>课程名称</td>
				<td>授课时间</td>
				<td>授课地点</td>
				<td>授课教师</td>
			</tr>
		</thead>
		<tbody>
			
			<?php foreach ($tables as $val):?>
			<tr>
				<td><?php echo $val['curriculumText'];?></td>
				<td><?php echo $val['lessonDate'] . ' ' . $val['lessonStartTime'] . '~' .$val['lessonEndTime'];?></td>
				<td><?php echo $val['teachPlace'];?></td>
				<td><?php echo $val['teacherName'];?></td>
			</tr>
			<?php endforeach;?>
			
			<?php if(empty($tables)):?>
				<tr><td colspan="4" style="text-align: center">暂时没有课程安排</td></tr>
			<?php endif;?>
		
		</tbody>
	</table>
	<div class="table-marks">备注：<?php echo $schedule->marks;?></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFrontPage.css');
$css = <<<CSS
.table-marks{width: 900px;margin: 0 auto;margin-top: 10px;}
.schedule-table{
	width: 900px;
    border: 1px solid #f3f3f3;
    border-radius: 2px;
    margin: 0 auto;
    margin-top: 50px;
	border-spacing: 1px;
}
.schedule-table caption{font-size: 20px;font-weight: 700;margin-bottom:20px;}
.schedule-table thead{background:#f3f3f3;}
.schedule-table thead td{font-size:15px;font-weight:700;}
.schedule-table td{text-align:center;height:32px;line-height:32px;}

.schedule-table tbody tr:hover{background:#bfedf5;}

CSS;
$js = <<<JS

JS;
$this->registerJs($js);
$this->registerCss($css);
?>