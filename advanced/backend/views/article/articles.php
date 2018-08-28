<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['article/articles'])?>">文章管理</a></li>
    </ul>
</div>

<div class="rightinfo">
	<?php echo Html::beginForm(Url::to(['article/articles']),'get');?>
	<ul class="seachform">
        <li><label>主题/作者</label><?php echo Html::activeTextInput($model, 'search[keywords]',['class'=>'scinput','placeholder'=>'文章主题或文章作者'])?></li>
        <li>
            <label>分类</label>  
            <div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[categoryId]', ArrayHelper::map($parentCates,'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li>
        	<label>图片提供者</label>
        	<?php echo Html::activeTextInput($model, 'search[imgProvider]',['class'=>'scinput','placeholder'=>'文章图片提供者'])?>
        </li>
        
        <li>
            <label>是否有主图</label>  
            <div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isTitleImg]', ['0'=>'无图','1'=>'有图'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li>
            <label>是否发布</label>  
            <div class="vocation">
                <?php echo Html::activeDropDownList($model, 'search[isPublish]', ['0'=>'未发布','1'=>'已发布'],['prompt'=>'请选择','class'=>'sky-select'])?>
            </div>
        </li>
        
        <li>
        	<label>发布时间</label>
        	<?php echo Html::activeTextInput($model, 'search[publishStartTime]',['class'=>'scinput publishStartTime','placeholder'=>'开始时间'])?> - 
    		<?php echo Html::activeTextInput($model, 'search[publishEndTime]',['class'=>'scinput publishEndTime','placeholder'=>'结束时间'])?>
        </li>
        
        <li><label>&nbsp;</label><?php echo Html::submitInput('查询',['class'=>'scbtn'])?></li>
        <li><a href="<?php echo Url::to(['article/create'])?>" class="add-btn">添加</a></li>
        <li><a href="javascript:;" class="del-btn batchDel">删除</a></li>
        <li><a href="javascript:;" class="excel-btn">导出</a></li>
    </ul>
    <?php echo Html::endForm();?>
</div>

<div class="warnning" style="margin-top: 15px">
	<h4 class="title"><a href="javascript:;" class="closeTips"><i>-</i> 注意事项：</a></h4>
	<ul>
		<li>1、列表数据(包括前台新闻列表)统一按发布时间进行倒序排序</li>
		<li>2、当前新闻文章已发布且已上传新闻主图，则可以设置为首页轮播推荐位(推荐一、推荐二、推荐三)；<i style="color: red">设置成功立即生效，直接替换上次对应推荐位的新闻 </i></li>
	</ul>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th><input name="" type="checkbox" class="s-all" /></th>
            <th>序号<i class="sort"><img src="/admin/images/px.gif" /></i></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th>图片数</th>
            <th>图片提供者</th>
            <th>预览数</th>
            <th>是否发布</th>
            <th>发布时间</th>
            <th>是否有图片</th>
            <!-- <th>是否推荐</th>
            <th>是否置顶</th>
            <th>排序</th> -->
            <th>院领导</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<?php foreach ($list['data'] as $val):?>
    	<tr>
            <td><input name="ids" type="checkbox" class="item" value="<?php echo $val['id'];?>" /></td>
            <td><?php echo $val['id'];?></td>
            <td><?php echo $val['title'];?></td>
            <td><?php echo $val['author'];?></td>
            <td><?php echo $val['categorys']['text'];?></td>
            <td><?php echo $val['imgCount'] ;?> </td>
            <td><?php echo $val['imgProvider'] ;?> </td>
            <td><?php echo $val['readCount'];?></td>
            <td><?php echo $val['isPublish'] == 0 ?'未发布' : '已发布';?></td>
            <td><?php echo MyHelper::timestampToDate($val['publishTime']);?></td>
            <td><?php echo !empty($val['titleImg']) ? '有图' : '无图' ;?> </td>
            <!-- <td><?php echo $val['isRecommen'] == 1 ? '是' : '否' ;?> </td>
            <td><?php echo $val['ishot'] == 1 ? '是' : '否' ;?> </td>
            <td><?php echo $val['sorts'] ;?> </td> -->
            <td><?php echo $val['leader'] ;?> </td>
            <td><?php echo MyHelper::timestampToDate($val['createTime']);?></td>
            <td><?php echo MyHelper::timestampToDate($val['modifyTime']);?></td>
            <td class="handle-box">
            	<a href="<?php echo Url::to(['article/edit','id'=>$val['id']])?>" class="tablelink">编辑</a>    
             	<a href="<?php echo Url::to(['article/del','id'=>$val['id']])?>" class="tablelink"> 删除</a>
             	
             	<?php if(!empty($val['titleImg']) && $val['isPublish'] == 1):?>
         			  <a href="<?php echo Url::to(['article/recommen-one','id'=>$val['id']])?>" class="tablelink">推荐一</a>     	
             		  <a href="<?php echo Url::to(['article/recommen-two','id'=>$val['id']])?>" class="tablelink">推荐二</a> 
             		  <a href="<?php echo Url::to(['article/recommen-three','id'=>$val['id']])?>" class="tablelink">推荐三</a> 
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
.article-tags{padding:3px 8px;border:0;border-radius: 5px;background:#e4e4e0;display: inline;}
CSS;
$batchDelUrl = Url::to(['article/batchdel']);
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$exportUrl = Url::to(['article/export']);
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

//时间选择框
var now = new Date();
var yearEnd = now.getFullYear() + 1;
var yearStart = yearEnd - 10;
var maxDate = now.setFullYear(yearEnd);
$.datetimepicker.setLocale('ch');
$('.publishStartTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:false    //开启选择今天按钮
});

$('.publishEndTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      maxDate : maxDate,
      //maxTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

//导出
// $(document).on('click','.excel-btn',function(){
//     var form = $(this).parents('form')[0];
//     $(form).attr('action','$exportUrl');
//     $(form).submit();
// })
JS;
AppAsset::addCss($this, '/admin/css/jquery.datetimepicker.css');
AppAsset::addScript($this, '/admin/js/jquery.datetimepicker.full.js');
$this->registerJs($js);
$this->registerCss($css);
?>