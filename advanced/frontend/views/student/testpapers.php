<?php

use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;

$controller = Yii::$app->controller;
$params = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id],$params));

$this->title= '在线测评试卷';
?>

<p class="position"><a href ="<?php echo Url::to(['site/index'])?>">学院首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo $url?>">在线测评试卷</a></p>
<div class="content">
<ul class="testpaper-list">
	<?php foreach ($list['data'] as $val):?>
	<li>
		<a href="<?php echo Url::to(['student/answer','id'=>$val['id']])?>"><?php echo $val['title']?><b>【答题时间：<?php echo $val['timeToAnswer'];?>（分钟）】</b></a>                     <span class="publish-time"><?php echo MyHelper::timestampToDate($val['publishTime'],'Y-m-d')?></span> 
	</li>
	<?php endforeach;?>
</ul>
	
	<div class="page">
        <!-- 这里显示分页 -->
        <div id="Pagination"></div>
    </div>
</div>
<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFrontPage.css');
AppAsset::addCss($this, '/front/css/pagination.css');
AppAsset::addScript($this, '/front/js/jquery.pagination.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
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