<?php


use common\publics\MyHelper;
use frontend\assets\AppAsset;
use yii\helpers\Url;

$this->title = $keywords.'_站内搜索';
?>

<ul class="search-list">
<?php foreach ($result['data'] as $val):?>
	<li><a href="<?php echo Url::to(['news/detail','id'=>$val['id']])?>"><?php echo $val['title']?></a><span><?php echo MyHelper::timestampToDate($val['publishTime'])?></span></li>
<?php endforeach;?>

<?php if(empty($result['data'])):?>
	<li>抱歉！没有找到你想要的新闻</li>
<?php endif;?>

</ul>

<div class="page">
    <!-- 这里显示分页 -->
    <div id="Pagination"></div>
</div>
<?php 
AppAsset::addCss($this, '/front/css/search.css');
AppAsset::addCss($this, '/front/css/pagination.css');
AppAsset::addScript($this, '/front/js/jquery.pagination.js');
$curPage = $result['curPage'];
$pageSize = $result['pageSize'];
$count = $result['count'];
$uri = Yii::$app->request->getUrl();
$js = <<<JS
initPagination({
	el : "#Pagination",
	count : $count,
	curPage : $curPage,
	pageSize : $pageSize,
    uri : '$uri'
});
JS;
$this->registerJs($js);
?>
