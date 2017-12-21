<?php


?>
<div class="row">
	<div class="col-ms-3">文章模块</div>
	<div class="col-ms-3">文章模块</div>
	<div class="col-ms-3">文章模块</div>
	<div class="col-ms-3">文章模块</div>
</div>

<!-- <div class="manage-module">
	<span>文章模块</span>
</div>
<div class="manage-module">
	<span>图片模块</span>
</div>
<div class="manage-module">
	<span>视频中心</span>
</div>
<div class="manage-module">
	<span>下载中心</span>
</div>
<div class="manage-module">
	<span>首页轮播</span>
</div>
<div class="manage-module">
	<span>教学基地</span>
</div>
<div class="manage-module">
	<span>社院人物</span>
</div>
<div class="manage-module">
	<span>底部链接</span>
</div> -->

<?php 
$css = <<<CSS
.manage-module{
    width : 200px;
    height :100px;
    border: 1px solid red;
    float:left;
    margin-left : 30px;
    margin-bottom :20px;
}
CSS;

$this->registerCss($css);

?>