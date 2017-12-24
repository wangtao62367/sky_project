<?php  
use yii\helpers\Url;

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>网站后台管理系统</title>
		<style>
			*{margin: 0;padding: 0;border: 0;}
			body{margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;overflow: hidden;}
			header{width: 100%;height: 88px;}
			.left-side,.right-side{position: absolute;top: 88px;bottom: 0;}
			.left-side{display: block;height: auto;float: left;width: 187px;left: 0;}
			.right-side{display: block;float: left;left: 187px;right: 0;}
		</style>
	</head>
	<body>
		<header>
			<iframe framespacing="0" width="100%"  height="88px" name="topFrame" scrolling="No" border="0" id="topFrame" src="<?php echo Url::to(['default/top']);?>"></iframe>
		</header>
		<aside class="left-side">
			<iframe width="187" height="100%" framespacing="0" frameborder="0" scrolling="no" src="<?php echo Url::to(['default/left']);?>" name="leftFrame"  noresize="noresize" id="leftFrame" frameborder='0'></iframe>
		</aside>
		<section class="right-side ">
			<iframe framespacing="0" width="100%" height="100%"  src="<?php echo Url::to(['default/main']);?>" name="rightFrame" id="rightFrame" title="rightFrame" border="0"></iframe>
		</section>
	</body>
</html>
