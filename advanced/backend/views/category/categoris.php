<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '文章分类列表';


?>

<div class="searchform">
<?php echo Html::beginForm(Url::to(['category/categoris']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('分类名称：','text');?>
		<?php echo Html::activeTextInput($model, 'search[text]');?>
		
		<?php echo Html::label('显示区域：','positions');?>
		<?php echo Html::activeDropDownList($model, 'search[type]', array_merge(['unknow'=>'请选择'],$model->type_arr));?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['category/create']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>

<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">分类名称</td>
    	<td class="spec">类型归类</td>
    	<td class="spec">分类描述</td>
    	<td class="spec">创建时间</td>
    	<td class="spec">编辑时间</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $cate):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $cate['id'];?>" />
  	</td>
    <td class="category_text" data-id="<?php echo $cate['id'];?>"><?php echo $cate['text'];?></td>
    <td><?php echo $cate['type_text'];?></td>
    <td><?php echo $cate['descr'];?></td>
    <td><?php echo date('Y-m-d H:i:s',$cate['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$cate['modifyTime']);?></td>
    <td>
    	<?php echo Html::a('编辑',Url::to(['category/edit','id'=>$cate['id']]))?>
    	<?php echo Html::a('删除',Url::to(['category/del','id'=>$cate['id']]))?>
    </td>
  </tr>
<!--   <tr> -->
<!--   	<td colspan="6"></td> -->
<!--   </tr> -->
  <?php endforeach;?> 
</table> 
<div class="pagination"></div>

<?php 
AppAsset::addScript($this, 'admin/js/jquery.pagination.js');
AppAsset::addScript($this, 'admin/js/jquery.pagination.config.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$url = Url::to(['category/edit-by-ajax']);
$js =<<<JS
$(".pagination").paginationCfg({
    totalData : $count,
    showData  : $pageSize,
    current   : $curPage,
});
$('#showChilder').click(function(ev){
    if($(this).hasClass('open')){
        $(this).find('i').text('▼');
        $(this).removeClass('open');
    }else{
        $(this).find('i').text('▲');
        $(this).addClass('open');
    }
    console.log(this)
});
JS;
$this->registerJs($js);

?>