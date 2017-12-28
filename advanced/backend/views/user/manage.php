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
	<ul class="seachform">
        <li><label>用户账号</label><?php echo Html::activeTextInput($model, 'search[trueName]',['class'=>'scinput'])?></li>
        <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
        <li class="click"><a href="<?php echo Url::to(['user/reg'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        <li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        <li><span><img src="/admin/images/t04.png" /></span>导出</li>
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
            <td><?php echo $val['email'];?></td>
            <td><?php echo $val['phone'];?></td>
            <td><?php echo long2ip($val['loginIp']);?></td>
            <td><?php echo $val['loginCount'];?></td>
            <td><?php echo $val['isFrozen'] == '1' ? '<font class="frozen">冻结</font>' : '<font class="actived">激活</font>';?></td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td>
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
<?php 
$css = <<<CSS

CSS;
$batchDelUrl = Url::to(['user/batchdel']);
$js = <<<JS
$('.batchDel').click(function(){
    batchDel('$batchDelUrl');
})
JS;
$this->registerJs($js);
$this->registerCss($css);
?>