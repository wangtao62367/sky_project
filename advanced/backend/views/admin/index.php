<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = '管理员列表';
?>

<div class="searchform">
<?php echo Html::beginForm(Url::to(['admin/index']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('管理员账号：','account');?>
		<?php echo Html::activeTextInput($model, 'search[account]');?>
		
		<?php echo Html::label('管理员邮箱：','adminEmail');?>
		<?php echo Html::activeTextInput($model, 'search[adminEmail]');?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['admin/add']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>


<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">管理员账号</td>
    	<td class="spec">管理员邮箱</td>
    	<td class="spec">登陆次数</td>
    	<td class="spec">登陆Ip</td>
    	<td class="spec">上次登陆Ip</td> 
    	<td class="spec">创建时间</td>
    	<td class="spec">更新时间</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $adm):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $adm['id'];?>" />
  	</td>
    <td><?php echo $adm['account'];?></td>
    <td><?php echo $adm['adminEmail'];?></td>
    <td><?php echo $adm['loginCount'];?></td>
    <td><?php echo long2ip($adm['loginIp']) ;?></td>
    <td><?php echo long2ip($adm['lastLoginIp']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$adm['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$adm['modifyTime']);?></td>
    <td>
    	<?php echo Html::a('编辑',Url::to(['article/edit','id'=>$adm['id']]),['title'=>'编辑/查看文章'])?>
    	<?php if(!(bool)$adm['isSuper']) :?>
    	<a href="javascript:;" class='resetpwd' data-id="<?php echo $adm['id'];?>"  title="重置密码" >重置密码</a> &nbsp;
    	<a href="javascript:;" class='del' data-id="<?php echo $adm['id'];?>"  title="删除管理员" >删除</a> &nbsp;
    	<?php endif;?>
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
$resetpwd_url = Url::to(['admin/ajax-resetpwd']);
$del_url = Url::to(['admin/ajax-del']);
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
$this->registerJs($js);
?>