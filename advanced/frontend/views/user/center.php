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
		
		<li><a href="<?php echo Url::to(['user/info']);?>" >我的信息</a></li>
		
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
					<a href="<?php echo  Url::to(['student/bminfo','cid'=>$val['gradeClassId']])?>"><?php echo $val['gradeClass']?></a>
					<p><span class="bm-time"><?php $e=time();$c = $val['createTime']; $day = intval(($e-$c)/86400);if($day==0){echo '今天';}else{echo $day.'天前';}; ?></span> 报的名</p>
				</div>
				<div class="bmx">
					<?php if($val['verify'] == 1):?>
            			<font class="verify-status status-ing">初审中</font>
            		<?php elseif ($val['verify'] == 2):?>
            			<font class="verify-status status-ing">终审中</font>
            		<?php elseif ($val['verify'] == 3):?>
            			<font class="verify-status status-yes">审核通过</font>	
            		<?php else:?>
            			<font class="verify-status status-no">审核失败</font>
            		<?php endif; ?>
					<br/>
					<?php if(TestPaper::checkExistByGradeClassId($val['gradeClassId'])):?>
					<a href="<?php echo Url::to(['student/testpapers','cid'=>$val['gradeClassId']])?>" ><b style="color: #333;font-weight: inherit;">【相关测评试卷】</b></a>
					<?php endif;?>
					<a href="<?php echo Url::to(['student/bminfo','cid'=>$val['gradeClassId']]);?>"><b >【查看信息】</b></a>
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
.bm-time,.verify-status{color:red;}
.verify-status{font-weight:700;}
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