<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

$this->title = '我要报名-查看报名信息';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="<?php echo Url::to(['user/center']); ?>" class="UnitedFront">我的报名</a></li>
		
		<li><a href="javascript:;" >修改信息</a></li>
		
		<li><a href="<?php echo Url::to(['user/edit-pwd']);?>"  >修改密码</a></li>

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
		
		<table class="bminfo">

<tr class="maxrow">
	<td class="title">审核状态</td>
	<td colspan="5">
		<?php if($info['verify'] == 1):?>
			<font class="verify-status status-ing">初审中</font>
		<?php elseif ($info['verify'] == 2):?>
			<font class="verify-status status-ing">终审中</font>
			<p>初审：<?php echo $info['verifyReason1'];?></p>
		<?php elseif ($info['verify'] == 3):?>
			<font class="verify-status status-yes">审核通过</font>	
			<p>初审：<?php echo $info['verifyReason1'];?></p>
			<p>终审：<?php echo $info['verifyReason2'];?></p>
		<?php else:?>
			<font class="verify-status status-no">审核失败</font>
			<?php if(!empty($info['verifyReason1'])):?>
			<p>初审：<?php echo $info['verifyReason1'];?></p>
			<?php endif;?>
			<?php if(!empty($info['verifyReason2'])):?>
			<p>初审：<?php echo $info['verifyReason2'];?></p>
			<?php endif;?>
		<?php endif; ?>
	</td>
</tr>

<tr>
	<td colspan="7">
		<h3 style="text-align: center">报名信息如下</h3>
	</td>
</tr>

<tr>
	<td class="title">姓名</td><td><?php echo $info['student']['trueName'];?></td>
	<td class="title">性别</td><td><?php echo $info['student']['sex'] == '1' ?'男':'女';?></td>
	<td class="title" rowspan="3">头像</td><td rowspan="3"><img class="avater" alt="头像" width="120px" height="120px" src="<?php echo $info['student']['avater'];?>"></td>
</tr>

<tr>
	<td class="title">民族</td><td><?php echo $info['student']['nation'];?></td>
	<td class="title">出生年月</td><td><?php echo $info['student']['birthday'];?></td>
</tr>

<tr>
	<td class="title">政治面貌</td><td><?php echo $info['student']['politicalStatus'];?></td>
	<td class="title">身份证号</td><td><?php echo $info['student']['IDnumber'];?></td>
</tr>

<tr>
	<td class="title">所在城市</td><td><?php echo $info['student']['city'];?></td>
	<td class="title">详细地址</td><td colspan="3"><?php echo $info['student']['address'];?></td>
</tr>

<tr>
	<td class="title">报名班级</td><td colspan="2"><?php echo $info['gradeClass'];?></td>
	<td class="title">联系电话</td><td colspan="2"><?php echo $info['student']['phone'];?></td>
</tr>

<tr>
	<td class="title">毕业学校</td><td><?php echo $info['student']['graduationSchool'];?></td>
	<td class="title">毕业专业</td><td><?php echo $info['student']['graduationMajor'];?></td>
	<td class="title">学历</td><td><?php echo $info['student']['eduation'];?></td>
</tr>

<tr>
	<td class="title">工作单位</td><td colspan="5"><?php echo $info['student']['company'];?></td>
</tr>

<tr>
	<td class="title">工作年限</td><td><?php echo $info['student']['workYear'];?>年</td>
	<td class="title">职称</td><td colspan="3"><?php echo $info['student']['positionalTitles'];?></td>
</tr>

<tr class="maxrow">
	<td class="title">个人简历</td><td colspan="5"><?php echo $info['student']['selfIntruduce'];?></td>
</tr>



</table>
		
	</div>
</div>
<div style="clear: both"></div>
</div>



<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
$css=<<<CSS
.section .content ._hr {
    width: 890px;
    height: 3px;
    float: left;
    margin-top: -20px;
    margin-left: 15px;
}
.section .content .first {
    width: 255px;
    background-color: #D34231;
    float: left;
}
.section .content .second {
    width: 615px;
    float: left;
}
.bminfo{border-spacing:0px;
	border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: solid;
    border-right-style: none;
    border-bottom-style: none;
    border-left-style: solid;
    border-top-color: #6996c4;
    border-right-color: #6996c4;
    border-bottom-color: #6996c4;
    border-left-color: #6996c4;
    font-family: "宋体";
    font-size: 12px;
    font-weight: normal;
    text-decoration: none;
    line-height: 2.2em;
    margin: auto;
}
.bminfo td {
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: none;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: none;
    border-top-color: #6996c4;
    border-right-color: #6996c4;
    border-bottom-color: #6996c4;
    border-left-color: #6996c4;
    /* background-color: #f2fafd; */
    height: 34px;
    vertical-align: middle;
    font-family: "宋体";
    font-size: 14px;
    text-indent: 6px;
	font-size: 12px;
    line-height: 2.2em;
    font-weight: normal;
    color: #000;
    text-decoration: none;
    letter-spacing: normal;
	min-width:120px;
	padding:10px;
}
.bminfo .title{text-align:center;background-color: #f2fafd;}
.bminfo .maxrow{height:150px;}
.bminfo td .avater{display:block;margin: auto;border-radius: 5px;}
td .verify-status{color:red;font-weight:700;}
CSS;


$this->registerCss($css);
?>