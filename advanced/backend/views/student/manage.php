<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use common\models\Student;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户系统</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员管理</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['student/manage']),'get');?>
	<ul class="seachform">
        <li><label>学员姓名</label><?php echo Html::activeTextInput($model, 'search[trueName]',['class'=>'scinput'])?></li>
        <li><label>学员性别</label>
        	<div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[sex]', ['1'=>'男','2'=>'女'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li class="click"><a href="<?php echo Url::to(['statistics/student'])?>"><span><img src="/admin/images/t04.png" width="24px"/></span>统计</a></li>
        <li class="click"><a href="<?php echo Url::to(['student/export'])?>"><span><img src="/admin/images/f05.png" width="24px"/></span>导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>学员姓名</th>
            <th>联系电话</th>
            <th>性别</th>
            <th>名族</th>
            <th>职称</th>
            <th>所学专业</th>
            <th>所学班级</th>
            <th>报名时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['trueName'];?></td>
            <td><?php echo $val['phone'];?></td>
            <td><?php echo $val['sex'] == 1 ? '男':'女';?></td>
            <td><?php echo $val['nation'];?></td>
            <td><?php echo $val['positionalTitles'];?></td>
            <td><?php echo $val['currentMajor'];?></td>
            <td><?php echo $val['gradeClass'];?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td>
            <a href="<?php echo Url::to(['student/info','id'=>$val['id']]);?>" class="tablelink">查看</a>     
            <a href="<?php echo Url::to(['student/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['student/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
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
JS;
$this->registerJs($js);
$this->registerCss($css);
?>