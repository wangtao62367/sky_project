<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">新闻系统</a></li>
    <li><a href="<?php echo Url::to(['video/manage'])?>">内容管理</a></li>
    <li><a href="<?php echo Url::to(['video/manage'])?>">视频列表</a></li>
    </ul>
</div>
    
<div class="rightinfo">
    
    <div class="tools">
    <?php echo Html::beginForm(Url::to(['video/manage']),'get');?>
    	<ul class="seachform">
    		<li><label>视频名称</label><?php echo Html::activeTextInput($model, 'search[descr]',['class'=>'scinput'])?></li>
	        <li>
	            <label>分类</label>  
	            <div class="vocation">
	                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
	            </div>
	        </li>
	        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        	<li><a href="<?php echo Url::to(['video/add'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
        	<li><a href="javascript:;" class="batchDel"><span><img src="/admin/images/t03.png" /></span>删除</a></li>
        </ul>
        <?php echo Html::endForm();?>
        
<!--         <ul class="toolbar1"> -->
<!--         <li><span><img src="/admin/images/t05.png" /></span>设置</li> -->
<!--         </ul> -->
    
    </div>
    
    
	<ul class="imglist">
		<?php if($list['count'] == 0):?>
			<li class="data-empty" style="width: 100%">暂时没有数据</li>
		<?php endif;?>
	    <?php foreach ($list['data'] as $val):?>
	    <li class="selected">
	    <span><img width="100%" src="<?php echo $val['videoImg']?>" /></span>
	    <h2><a href="#"><?php echo $val['descr'];?></a></h2>
	    <p><a href="<?php echo Url::to(['video/edit','id'=>$val['id']])?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Url::to(['video/del','id'=>$val['id']])?>">删除</a></p>
	    </li>
	    <?php endforeach;?>
	</ul>

</div>

<?php 
$css=<<<CSS
.data-empty{
    width: 100%;
    text-align: center;
    line-height: 199px;
}


CSS;

$this->registerCss($css);

?>