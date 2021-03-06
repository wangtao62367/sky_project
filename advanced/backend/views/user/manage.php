<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户系统</a></li>
        <li><a href="<?php echo Url::to(['user/manage'])?>">用户管理</a></li>
        <li><a href="<?php echo Url::to(['user/manage'])?>">用户列表</a></li>
    </ul>
</div>

<div class="rightinfo">
<?php echo Html::beginForm(Url::to(['user/manage']),'get');?>
	<ul class="seachform">
        <li><label>用户账号</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput','placeholder'=>'用户账号/手机/邮箱'])?></li>
        <li>
        	<label>注册时间</label>
        	<?php echo Html::activeTextInput($model, 'search[startTime]',['class'=>'scinput startTime','placeholder'=>'开始时间'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[endTime]',['class'=>'scinput endTime','placeholder'=>'结束时间'])?>
        </li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['user/reg'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
    </ul>
<?php echo Html::endForm();?>
</div>

<div class="warnning">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、用户冻结以后不能登录成功。</li>
		<li>2、用户密码重置以后，用户登录密码将变为：111111a</li>
	</ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>手机</th>
            <th>最近登录IP</th>
            <th>登录次数</th>
            <th>状态</th>
            <th>注册时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['account'];?></td>
            <td><?php echo $val['email'];?></td>
            <td><?php echo $val['phone'];?></td>
            <td><?php echo long2ip($val['loginIp']);?></td>
            <td><?php echo $val['loginCount'];?></td>
            <td><?php echo $val['isFrozen'] == '1' ? '<font class="frozen">冻结</font>' : '<font class="actived">激活</font>';?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            <a href="<?php echo Url::to(['user/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a> 
            <?php if($val['isFrozen'] == 0):?>
            <a href="<?php echo Url::to(['user/frozen','id'=>$val['id']]);?>" class="tablelink">冻结</a> 
            <?php else :?>
            <a href="<?php echo Url::to(['user/active','id'=>$val['id']]);?>" class="tablelink">激活</a>
            <?php endif;?>
            <a href="<?php echo Url::to(['user/resetpwd','id'=>$val['id']]);?>" class="tablelink">重置密码</a>    
            <a href="<?php echo Url::to(['user/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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
$batchDelUrl = Url::to(['user/batchdel']);
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

//时间选择框
var now = new Date();
var yearEnd = now.getFullYear();
var yearStart = yearEnd - 10;
var maxDate = now.setFullYear(yearEnd);
$.datetimepicker.setLocale('ch');
$('.startTime').datetimepicker({
      format:"Y-m-d H:i:s",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:false    //开启选择今天按钮
});

$('.endTime').datetimepicker({
      format:"Y-m-d H:i:s",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});
JS;
$this->registerJs($js);
$this->registerCss($css);
?>