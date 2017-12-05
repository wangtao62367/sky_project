<?php   
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title="投票列表";

?>
<div class="searchform">
<?php echo Html::beginForm(Url::to(['vote/votes']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('投票主题：','subject');?>
		<?php echo Html::activeTextInput($model, 'search[subject]');?>
		
		<?php echo Html::label('选择类型：','selectType');?>
		<?php echo Html::activeDropDownList($model, 'search[selectType]', ['unknow'=>'请选择','single'=>'单选','multi'=>'多选']);?>
		
		<?php echo Html::label('投票状态：','isClose');?>
		<?php echo Html::activeDropDownList($model, 'search[isClose]', ['unknow'=>'请选择','0'=>'正常','1'=>'关闭']);?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['vote/add']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>

<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">投票主题</td>
    	<td class="spec">投票类型</td>
    	<td class="spec">开始时间</td>
    	<td class="spec">结束时间</td>
    	<td class="spec">创建时间</td>
    	<td class="spec">编辑时间</td>
    	<td class="spec">状态</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $vote):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $vote['id'];?>" />
  	</td>
    <td><?php echo $vote['subject'];?></td>
    <td><?php echo $vote['selectTypeText'];?></td>
    <td><?php echo $vote['startDate'];?></td>
    <td><?php echo $vote['endDate'];?></td>
    <td><?php echo date('Y-m-d H:i:s',$vote['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$vote['modifyTime']);?></td>
    <td><?php echo $vote['isCloseText'];?></td>
    <td>
    	<?php if(!(bool)$vote['isClose']) :?>
<!--     	<a href="javascript:;" title="关闭投票" >关闭</a> &nbsp; -->
    	<?php elseif ((bool)$vote['isClose']):?>
<!--     	<a href="javascript:;" title="开启投票" >关闭</a> &nbsp; -->
    	<?php endif;?>
    	<?php echo Html::a('编辑',Url::to(['vote/edit','id'=>$vote['id']]),['class'=>'btn','title'=>'编辑投票'])?>
    	<?php echo Html::a('详情',Url::to(['vote/view','id'=>$vote['id']]),['class'=>'btn','title'=>'查看投票详情'])?>
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
$js =<<<JS
$(".pagination").paginationCfg({
    totalData : $count,
    showData  : $pageSize,
    current   : $curPage,
});
JS;
$this->registerJs($js);

?>
