<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Student;
use yii\helpers\ArrayHelper;
use common\models\BmRecord;

$controller = Yii::$app->controller;
$query = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id], $query));
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务管理系统系统</a></li>
        <li><a href="<?php echo $url?>">在线报名审核</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm('','get');?>
	<ul class="seachform">
		<li><label>报名班级</label><?php echo Html::activeTextInput($model, 'search[gradeClass]',['class'=>'scinput'])?></li>
        <li><label>学员姓名</label><?php echo Html::activeTextInput($model, 'search[trueName]',['class'=>'scinput'])?></li>
        <li><label>学员性别</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[sex]', ['1'=>'男','2'=>'女'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="javascript:;" class="excel-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>
<div class="verify-btn">
	<a href="<?php echo Url::to(['student/verify-list','verify'=>1])?>" class="<?php echo !isset($query['verify']) || $query['verify'] == 1 ?'active':'' ?>">待初审</a>
	<a href="<?php echo Url::to(['student/verify-list','verify'=>2])?>" class="<?php echo isset($query['verify']) && $query['verify'] == 2?'active':'' ?>">待终审</a>
	<a href="<?php echo Url::to(['student/verify-list','verify'=>3])?>" class="<?php echo isset($query['verify']) && $query['verify'] == 3?'active':'' ?>">终审完成</a>
	<a href="<?php echo Url::to(['student/verify-list','verify'=>0])?>" class="<?php echo isset($query['verify']) && $query['verify'] == 0?'active':'' ?>">审核失败</a>
</div>
<table class="tablelist">
	<thead>
    	<tr>
            <th>学员姓名</th>
            <th>所报班级</th>
            <th>联系电话</th>
            <th>性别</th>
            <th>报名时间</th>
            <th>审核状态</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><?php echo $val['student']['trueName'];?></td>
            <td><?php echo $val['gradeClass'];?></td>
            <td><?php echo $val['student']['phone'];?></td>
            <td><?php echo $val['student']['sex'] == 1 ? '男':'女';?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td><?php echo BmRecord::$verify_texts[$val['verify']];?></td>
            <td>
            <?php if($val['verify'] == 0 ):?>
            <a href="<?php echo Url::to(['student/info','id'=>$val['id']]);?>" class="tablelink">查看</a> 
            <?php else :?>
            <a href="<?php echo Url::to(['student/info','id'=>$val['id']]);?>" class="tablelink">审核</a>
            <?php endif;?>    
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
.verify-btn{
    width:98%;
    margin:10px auto; 
}
.verify-btn a{
    display:inline-block;
    padding:5px 10px;
    background:#cc8181;
    color : #fff;
    border-radius:5px;
}
.verify-btn .active{background:#383333;}
CSS;
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$js = <<<JS

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