<?php
use yii\helpers\Url;
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">成功提示</a></li>
    </ul>
</div>
    
    <div class="success">
    
    <h2>恭喜您，操作成功！！</h2>
    <p>看到这个提示，<font class="jishu"><?php echo $m;?></font>秒后自动跳转。</p>
</div>
<?php 
$url = Url::to([$back]);
$js = <<<JS
var jishu = $('.jishu').text();
var setInter = setInterval(function(){
	jishu --;
    $('.jishu').text(jishu);
    if(jishu == 0){
        clearInterval(setInter);
        window.location.href = '$url';
    }
},1000);
JS;
$this->registerJs($js);
?>