<?php


use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\TestPaper;

$this->title = '我的报名';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="javascript:;" class="UnitedFront">我的报名</a></li>
		
		<li><a href="javascript:;" >修改信息</a></li>
		
		<li><a href="<?php echo Url::to(['user/edit-pwd']);?>" >修改密码</a></li>

	</ul>
</div>
<div class="content">
	<div class="caption">
		<h2><?php echo $this->title;?></h2>
	</div>
	<div class="_hr">
	    <hr class="first"/><hr class="second"/>
	</div>
	<div class="text">
		<ul class="gradeclass">
			<?php foreach ($list['data'] as $val):?>
			<li class="gradeclass-item">
				<div class="bms">
					<a href="<?php echo  Url::to(['student/info','id'=>$val['id']])?>"><?php echo $val['gradeClass']?></a>
					<p><span class="bm-time"><?php $e=time();$c = $val['createTime']; echo intval(($e-$c)/86400); ?></span> 前天报的名</p>
				</div>
				<div class="bmx">
					<br/>
					<?php if(TestPaper::checkExistByGradeClassId($val['gradeClassId'])):?>
					<a href="<?php echo Url::to(['student/testpapers','cid'=>$val['gradeClassId']])?>" ><b style="color: #333;font-weight: inherit;">【相关测评试卷】</b></a>
					<?php endif;?>
					<a href="<?php echo Url::to(['student/info','id'=>$val['id']]);?>"><b >【查看信息】</b></a>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="page">
            <!-- 这里显示分页 -->
            <div id="Pagination"></div>
        </div>
	</div>
</div>
<div style="clear: both"></div>
</div>

<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
AppAsset::addCss($this, '/front/css/pagination.css');
AppAsset::addScript($this, '/front/js/jquery.pagination.js');
$curPage = $list['curPage'];
$pageSize = $list['pageSize'];
$count = $list['count'];
$uri = Yii::$app->request->getUrl();
$css = <<<CSS
.gradeclass{margin-left: 15px;border-bottom: #d6d6d6 1px solid;}
.gradeclass-item .bmx {
    border-bottom: 0px;
}
.bm-time{color:red;}
.section .content ._hr {
    margin-top: -15px;
}
CSS;
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
$this->registerCss($css);
?>