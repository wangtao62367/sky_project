<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">系统设置</a></li>
        <li><a href="<?php echo Url::to(['admin/manage'])?>">管理员管理</a></li>
        <li><a href="<?php echo Url::to(['admin/manage'])?>">管理员列表</a></li>
    </ul>
</div>

<div class="rightinfo">
<?php echo Html::beginForm(Url::to(['admin/manage']),'get');?>
	<ul class="seachform">
        <li><label>管理员账号</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput','placeholder'=>'管理员账号/邮箱'])?></li>
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['admin/add'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="batchDel del-btn">删除</a></li>
    </ul>
<?php echo Html::endForm();?>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" value="" class="s-all" /></th>
            <th>管理员账号</th>
            <th>邮箱</th>
            <th>所属部门</th>
            <th>最近登录IP</th>
            <th>登录次数</th>
            <th>状态</th>
            <th>系统管理员</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" class="item" type="checkbox" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['account'];?></td>
            <td><?php echo $val['adminEmail'];?></td>
            <td><?php echo $val['department'] == 'admin' ? '' : $val['department'];?></td>
            <td><?php echo long2ip($val['loginIp']);?></td>
            <td><?php echo $val['loginCount'];?></td>
            <td><?php echo $val['isFrozen'] == '1' ? '<font class="frozen">冻结</font>' : '<font class="actived">激活</font>';?></td>
            <td><?php echo $val['isSuper'] == 1?'是':'否'?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
            <?php if(!(bool)$val['isSuper']):?>
            	 <a href="<?php echo Url::to(['admin/assign','id'=>$val['id']]);?>" class="tablelink">授权</a> 
	            <a href="<?php echo Url::to(['admin/edit','id'=>$val['id']]);?>" class="tablelink">编辑</a> 
	            <a href="<?php echo Url::to(['admin/resetpwd','id'=>$val['id']]);?>" class="tablelink">重置密码</a> 
	            <?php if($val['isFrozen'] == 0):?>
	            <a href="<?php echo Url::to(['admin/frozen','id'=>$val['id']]);?>" class="tablelink">冻结</a> 
	            <?php else :?>
	            <a href="<?php echo Url::to(['admin/active','id'=>$val['id']]);?>" class="tablelink">激活</a>
	            <?php endif;?>
	            <a href="<?php echo Url::to(['admin/del','id'=>$val['id']]);?>" class="tablelink"> 删除</a>
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

CSS;
$batchDelUrl = Url::to(['admin/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
});

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