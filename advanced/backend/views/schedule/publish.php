<?php

use yii\helpers\Html;
use backend\models\PublishCate;

?>


<!-- 发布框 -->
<div class="modal"></div>
<div class="tip " style="display: block;">	
	<div class="tiptop"><span>发布课表</span><a></a></div>  
	<?php echo Html::beginForm();?>	
	<div class="tipinfo">       
 		<ul class="forminfo">
        	<li><label>是否发布<b>*</b></label>
            	<div class="vocation">
            		<?php echo Html::activeDropDownList($model, 'publishCode', PublishCate::$publishTimeArr,['class'=>'sky-select','id'=>'isPublish'])?>
            	</div>
            </li>
            
            <li class="publishTimeByUser" <?php echo $model->isPublish === 'userDefined' ? 'style="display:block"' : 'style="display:none"'; ?>><label>发布时间<b>*</b></label><?php echo Html::activeTextInput($model, 'publishTime',['class'=>'dfinput','style'=>'width:308px;','id'=>"publishTime"])?><i></i></li>
            
            <li><label>发布结束时间<b>*</b></label>
            	<?php echo Html::activeTextInput($model, 'publishEndTime',['id'=>'publishEndTime','class'=>'dfinput','style'=>'width:308px;','placeholder'=>'发布结束时间'])?>
            </li>
 		</ul>
 		<p style="color:red;"><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p> 
	 </div>   
	 <div class="tipbtn">      
	   <input name="" type="submit" class="sure" value="确定">&nbsp;      
	     <input name="" type="button" class="cancel" value="取消">   
	  </div>
	  <?php echo Html::endForm();?>
</div>
<?php 

$js = <<<JS

$(document).on('change','#isPublish',function(){
    var val = $(this).val();
    if(val == 'userDefined'){
        $('.publishTimeByUser').show();
    }else{
        $('.publishTimeByUser').hide();
    }
})

var now = new Date();
var yearStart = now.getFullYear();
var yearEnd = yearStart + 1;
$.datetimepicker.setLocale('ch');
//时间选择框
$('#publishTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      minDate : now,
      minTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

$('#publishEndTime').datetimepicker({
      format:"Y-m-d H:m:i",      //格式化日期
      timepicker:true,    
      minDate : now,
      minTime : now,
      yearStart: yearStart,     //设置最小年份
      yearEnd:yearEnd,        //设置最大年份
      todayButton:true    //开启选择今天按钮
});

$(document).on('click','.tiptop a,.cancel',function(){
	$(".tip").remove();
	$(".modal").remove();
});
JS;

$this->registerJs($js);
?>