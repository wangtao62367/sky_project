<?php


use yii\helpers\Url;

?>
<div class="place">
    <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据错误提示</a></li>
        </ul>
    </div>
    
    <div class="error">
    
    <h2>非常遗憾，您访问的数据页面不存在！</h2>
    <p>看到这个提示，就自认倒霉吧!</p>
    <div class="reindex"><a href="<?php echo Url::to([$url])?>" >立即返回</a></div>
</div>
<?php 

?>