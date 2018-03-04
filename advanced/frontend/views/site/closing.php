<?php



$params = $this->params;
$this->title = $params['webCfgs']['siteName'].'_网站关闭';
?>

<div class="main">
	<h3>欢迎访问<?php echo $params['webCfgs']['siteName']?></h3>
	<p>非常抱歉本网站暂时关闭中,关闭理由是：<?php echo $params['webCfgs']['closeReasons']?></p>
</div>
<?php 
$css=<<<CSS
.main{min-height:500px;}
CSS;
$this->registerCss($css);
?>
