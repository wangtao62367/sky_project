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
		<?php echo Html::activeDropDownList($model, 'search[positions]', ['unknow'=>'请选择','top'=>'顶部区','hot'=>'热点区','normal'=>'通用区']);?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['category/create']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>

<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		
      	</td>
    	<td class="spec">分类名称</td>
    	<td class="spec">显示区域</td>
    	<td class="spec">分类描述</td>
    	<td class="spec">创建时间</td>
    	<td class="spec">编辑时间</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $cate):?>
  <tr>
  	<td class="checkbox">
  		<?php if($cate['parentId'] == 0):?>
  			<a id="showChilder"  href="javascript:;"><i>▼</i></a>
  		<?php endif;?>
  	</td>
    <td class="category_text" data-id="<?php echo $cate['id'];?>"><?php echo $cate['text'];?></td>
    <td><?php echo $cate['positions_text'];?></td>
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
$('.category_text').click(function(ev){
    if($('input[id=category_text]').length == 0){
        var cate_text = $(this).text();
        $(this).text('').append('<input type="text" name="text" id="category_text" value="'+cate_text+'" />');
    }
});
$(document).on('change','#category_text',function(ev){
    var _this = $(this);
    var cate_text = _this.val();
    var cate_id = _this.parent().data('id');
    $.get('$url',{id:cate_id,text:cate_text},function(res){
        if(res){
            _this.parent().empty().text(cate_text);
        }else{

        };
    })
});

JS;
$this->registerJs($js);

?>