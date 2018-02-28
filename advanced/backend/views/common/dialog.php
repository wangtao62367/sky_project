<?php

?>
<div class="tip">
    <div class="tiptop"><span>提示信息</span><a></a></div>  
      <div class="tipinfo">
    <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite><span class="duration"><?php echo $duration;?></span>秒后自动关闭窗口。</cite>
        </div>
    </div>
</div>
<?php 
$css=<<<CSS
.tip{
	height: 200px;
	width: 350px;
}

CSS;
$js = <<<JS
var dur = $duration;
var reload = '$reload';
var interval = setInterval(function(){
	$('.duration').text(dur --);
	if(dur == 0){
		clearInterval(interval);
		reload == 'true' && location.reload();
	}
	
},1000);
JS;
$this->registerJs($js);
$this->registerCss($css);
?>