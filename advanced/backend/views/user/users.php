<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = '用户列表';
?>


<div class="searchform">
<?php echo Html::beginForm(Url::to(['user/users']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('用户账号：','account');?>
		<?php echo Html::activeTextInput($model, 'search[account]');?>
		
		<?php echo Html::label('用户邮箱：','email');?>
		<?php echo Html::activeTextInput($model, 'search[email]');?>
		
		<?php echo Html::label('用户手机：','phone');?>
		<?php echo Html::activeTextInput($model, 'search[phone]');?>
		
		<?php echo Html::label('用户角色：','roleId');?>
		<?php echo Html::activeDropDownList($model, 'search[roleId]', ArrayHelper::map($roles, 'id', 'roleName') , ['prompt'=>'请选择','prompt_val'=>'0','style'=>'width:100px'])?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['user/reg']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>


<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">用户账号</td>
    	<td class="spec">用户邮箱</td>
    	<td class="spec">用户手机</td>
    	<td class="spec">用户角色</td>
    	<td class="spec">登陆次数</td>
    	<td class="spec">登陆Ip</td>
    	<td class="spec">上次登陆Ip</td> 
    	<td class="spec">创建时间</td>
    	<td class="spec">更新时间</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $user):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $user['id'];?>" />
  	</td>
    <td><?php echo $user['account'];?></td>
    <td><?php echo $user['email'];?></td>
    <td><?php echo $user['phone'];?></td>
    <td><?php echo $user['roleName'];?></td>
    <td><?php echo $user['loginCount'];?></td>
    <td><?php echo long2ip($user['loginIp']) ;?></td>
    <td><?php echo long2ip($user['lastLoginIp']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$user['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$user['modifyTime']);?></td>
    <td>
    	<?php echo Html::a('编辑',Url::to(['user/edit','id'=>$user['id']]),['title'=>'编辑/查看用户'])?> 
    	<?php echo Html::a('重置密码','javascript:;',['title'=>'重置密码','data-id'=>$user['id'],'class'=>'btn resetpwd'])?> 
    	<?php echo Html::a('删除','javascript:;',['title'=>'删除用户','data-id'=>$user['id'],'class'=>'btn del'])?> 
    </td>
  </tr>
  <?php endforeach;?> 
</table> 
<div class="pagination"></div>
<?php 
AppAsset::addScript($this, 'admin/js/jquery.pagination.js');
AppAsset::addScript($this, 'admin/js/jquery.pagination.config.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$resetpwd_url = Url::to(['user/ajax-resetpwd']);
$del_url = Url::to(['user/ajax-del']);
$js =<<<JS
$(".pagination").paginationCfg({
    totalData : $count,
    showData  : $pageSize,
    current   : $curPage,
});
$('.resetpwd').click(function(){
    var id = $(this).data('id');
    $.get('$resetpwd_url',{id:id},function(res){
        if(res){
            showSuccess('密码重置成功',2,function(){window.location.reload();});
        }
    })
})
$('.del').click(function(){
    var id = $(this).data('id');
    $.get('$del_url',{id:id},function(res){
        if(res){
            showSuccess('删除成功',2,function(){window.location.reload();});
        }
    })
})
JS;
$css = <<<CSS

CSS;
$this->registerCss($css);
$this->registerJs($js);
?>