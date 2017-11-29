<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


?>

<div class="searchform">
<?php echo Html::beginForm(Url::to(['article/articles']));?>
 	<div class = "form-group"> 
		<?php echo Html::label('文章主题：','title');?>
		<?php echo Html::activeTextInput($model, 'search[title]');?>
		
		<?php echo Html::label('文章类型：','categoryId');?>
		<?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates, 'id', 'text') , ['prompt'=>'请选择','prompt_val'=>'0','style'=>'width:100px']);?>
		
		<?php echo Html::label('是否发布：','isPublish');?>
		<?php echo Html::activeDropDownList($model, 'search[isPublish]', ['unknow'=>'请选择','0'=>'未发布','1'=>'已发布'],['style'=>'width:100px']);?>
		
		<?php echo Html::submitInput('搜 索',['class'=>'btn btn-success'])?>
		<?php echo Html::resetInput('重 置',['class'=>'btn'])?>
		
		<?php echo Html::a('添 加',Url::to(['article/create']),['class'=>'btn btn-primary']);?>
		<?php echo Html::a('批量发布',Url::to(['article/publish-all']),['class'=>'btn btn-primary']);?>
 	</div> 
<?php echo Html::endForm();?>
</div>


<table width="100%" class="table">   
    <tr class="theader">
    	<td class="checkbox">
      		<input type="checkbox" class="s_all" />
      	</td>
    	<td class="spec">文章主题</td>
    	<td class="spec">文章类型</td>
    	<td class="spec">文章作者</td>
    	<td class="spec">文章标签</td>
    	<td class="spec">创建时间</td> 
    	<td class="spec">编辑时间</td>
    	<td class="spec">是否发布</td>
    	<td class="spec">操作</td>
    </tr>
  <?php foreach ($list['data'] as $artic):?>
  <tr>
  	<td class="checkbox">
  		<input type="checkbox" name="id[]" class="checkbox_item" value="<?php echo $artic['id'];?>" />
  	</td>
    <td><?php echo $artic['title'];?></td>
    <td><?php echo $artic['categorys']['text'];?></td>
    <td><?php echo $artic['author'];?></td>
    <td>
    <?php 
    foreach ($artic['articletags'] as $k=>$at){
        echo '<i class="select2-selection__choice">'.$at['tags']['tagName'].'</i>';
    }?>
    </td>
    <td><?php echo date('Y-m-d H:i:s',$artic['createTime']);?></td>
    <td><?php echo date('Y-m-d H:i:s',$artic['modifyTime']);?></td>
    <td>
    	<?php if(!(bool)$artic['isPublish']) :?>
    	<a href="javascript:;" class="btn btn-primary article_pulish" data-id="<?php echo $artic['id'];?>" title="发布文章" >发布</a> &nbsp;
    	<?php elseif ((bool)$artic['isPublish']):?>
    	<a href="javascript:;" class="btn btn-danger article_close" data-id="<?php echo $artic['id'];?>" title="关闭发布" >关闭</a> &nbsp;
    	<?php endif;?>
    </td>
    <td>
    	<?php echo Html::a('编辑',Url::to(['article/edit','id'=>$artic['id']]),['title'=>'编辑/查看文章'])?>
    	<?php echo Html::a('删除',Url::to(['article/del','id'=>$artic['id']]),['title'=>'删除文章']);?>
    </td>
  </tr>
  <?php endforeach;?> 
</table> 
<div class="pagination"></div>
<?php 
$css = <<<CSS
.select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px; 
	background-color: #5cb85c;
	color:#fff;
    font-style: normal;
}
CSS;
AppAsset::addScript($this, 'admin/js/jquery.pagination.js');
AppAsset::addScript($this, 'admin/js/jquery.pagination.config.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$url = Url::to(['article/publish']);
$js =<<<JS
$(".pagination").paginationCfg({
    totalData : $count,
    showData  : $pageSize,
    current   : $curPage,
});
$(document).on('click','.article_pulish',function(ev){
    var _this = $(this);
    var id = _this.data('id');
    $.get('$url',{id:id,type:'publish'},function(res){
        _this.removeClass('btn-primary article_pulish').addClass('btn-danger article_close').attr('title','关闭发布').text('关闭');
    });
});
$(document).on('click','.article_close',function(ev){
    var _this = $(this);
    var id = _this.data('id');
    $.get('$url',{id:id,type:'close'},function(res){
        _this.removeClass('btn-danger article_close').addClass('btn-primary article_pulish').attr('title','发布文章').text('发布');
    });
});
JS;
$this->registerCss($css);
$this->registerJs($js);
?>