<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\QuestCategory;

$this->title = '测评试题列表';
?>

<div class="searchform">
<?php echo Html::beginForm(Url::to(['question/index']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('试题标题：','title');?>
		<?php echo Html::activeTextInput($model, 'search[title]');?>
		
		<?php echo Html::label('试题类型：','cate');?>
		<?php echo Html::activeDropDownList($model, 'search[cate]', $questCate,['style'=>'width:100px'])?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['question/add']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>


<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">试题标题</td>
    	<td class="spec">试题类型</td>
    	<td class="spec">正确选项</td>
    	<td class="spec">分数</td>
    	<td class="spec">状态</td> 
    	<td class="spec">创建时间</td>
    	<td class="spec">更新时间</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $quest):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $quest['id'];?>" />
  	</td>
    <td><?php echo $quest['title'];?></td>
    <td><?php echo QuestCategory::getQuestCateText($quest['cate']) ;?></td>
    <td><?php echo $quest['answerOpt'];?></td>
    <td><?php echo $quest['score'] ;?></td>
    <td><?php echo $quest['isPublishText'];?></td>
    <td><?php echo date('Y-m-d H:i:s',$quest['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$quest['modifyTime']);?></td>
    <td>
    	<?php echo Html::a('编辑',Url::to(['question/edit','id'=>$quest['id']]),['title'=>'编辑/查看文章','class'=>'btn'])?>
    	<?php if($quest['isPublish'] == 0):?>
    	<?php echo Html::a('发布','javascript:;',['title'=>'发布试题','class'=>'publish btn','data-id'=>$quest['id']])?>
    	<?php else:?>
    	<?php echo Html::a('取消','javascript:;',['title'=>'取消试题','class'=>'unpublish btn','data-id'=>$quest['id']])?>
    	<?php endif;?>
    	<?php echo Html::a('删除','javascript:;',['title'=>'删除试题','class'=>'del btn','data-id'=>$quest['id']])?>
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
$del_url = Url::to(['question/ajax-del']);
$publish_url = Url::to(['question/ajax-publish']);
$publish_url = Url::to(['question/ajax-unpublish']);
$js =<<<JS
$(".pagination").paginationCfg({
    totalData : $count,
    showData  : $pageSize,
    current   : $curPage,
});
$('.del').click(function(){
    var id = $(this).data('id');
    $.get('$del_url',{id:id},function(res){
        if(res){
            showSuccess('删除成功',2,function(){window.location.reload();});return;
        }
        showError('操作失败','','');
    })
})
$('.publish').click(function(){
    var id = $(this).data('id');
    $.get('$publish_url',{id:id},function(res){
        if(res){
            showSuccess('发布成功',2,function(){window.location.reload();});return;
        }
        showError('操作失败','','');
    })
})
$('.unpublish').click(function(){
    var id = $(this).data('id');
    $.get('$publish_url',{id:id},function(res){
        if(res){
            showSuccess('取消成功',2,function(){window.location.reload();});return;
        }
        showError('操作失败','','');
    })
})
JS;
$css = <<<CSS
table .btn{
    padding : 3px 5px;
}
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>