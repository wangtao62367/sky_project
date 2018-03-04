<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$controller = Yii::$app->controller;
$query = Yii::$app->request->get();
$url =Url::to(ArrayHelper::merge([$controller->id.'/'.$controller->action->id], $query));
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">教务管理系统系统</a></li>
        <li><a href="<?php echo Url::to(['student/verify-list'])?>">在线报名审核</a></li>
        <li><a href="<?php echo $url;?>">查看/审核</a></li>
    </ul>
</div>

<div class="rightinfo">

<table class="studentInfo">
	<tr>
		<td class="title">姓名</td><td colspan="2"><?php echo $info->trueName;?></td>
		<td class="title">姓别</td><td colspan="2"><?php echo $info->sex == 1 ? '男' : '女';?></td>
		<td class="title">名族</td><td colspan="3"><?php echo $info->nation;?></td>
		<td class="title">政治面貌</td><td colspan="2"><?php echo $info->politicalStatus;?></td>
		<td class="title"  rowspan="4">头像</td><td colspan="4" rowspan="4"><img alt="头像" src="<?php echo $info->avater;?>"></td>
	</tr>
	<tr>
		<td class="title">出生年月</td><td colspan="2"><?php echo $info->birthday;?></td>
		<td class="title">身份证号</td><td colspan="9"><?php echo $info->IDnumber;?></td>
	</tr>
	<tr>
		<td class="title">联系电话</td><td colspan="2"><?php echo $info->phone;?></td>
		<td class="title">现居城市</td><td colspan="2"><?php echo $info->city;?></td>
		<td class="title">详细地址</td><td colspan="6"><?php echo $info->address;?></td>
	</tr>
	<tr>
		<td class="title">毕业学校</td><td colspan="5"><?php echo $info->graduationSchool;?></td>
		<td class="title">学历</td><td colspan="2"><?php echo $info->eduation;?></td>
		<td class="title">毕业专业</td><td colspan="3"><?php echo $info->graduationMajor;?></td>
	</tr>
	<tr>
		<td class="title" colspan="2">工作单位（公司）</td><td colspan="7"><?php echo $info->company;?></td>
		<td class="title">职称</td><td colspan="3"><?php echo $info->positionalTitles;?></td>
	    <td class="title">工作年限</td><td ><?php echo $info->workYear;?></td>
	</tr>
	<tr>
		<td class="title" colspan="2">个人介绍</td><td colspan="14"><?php echo $info->selfIntruduce;?></td>
	</tr>
	
	<tr>
		<td class="title" colspan="2">现报名班级</td><td colspan="14"><?php echo $bmRecord->gradeClass?></td>
	</tr>
	<tr>
		<td class="title" colspan="2">初始审核</td>
		<td colspan="14" class="verifyForm">
			<?php if($bmRecord->verify == 1):?>
				<?php echo Html::beginForm(Url::to(['student/verify-one','id'=>$bmRecord->id]),'post',['id'=>'verifyStep1']);?>
					<textarea rows="5" cols="7" name="reasons1" placeholder="请填写审核理由"></textarea>
					<input type="hidden" name="isAgree" />
					<a href="javascript:;" class="btn-verify agree">同意</a>
					<a href="javascript:;" class="btn-verify disagree">不同意</a>
				<?php echo Html::endForm();?>
			<?php else :?>
				<?php echo $bmRecord->verifyReason1;?>
			<?php endif;?>
		</td>
	</tr>
	<tr>
		<td class="title" colspan="2">二次审核</td>
		<td colspan="14" class="verifyForm">
			<?php if($bmRecord->verify == 2):?>
				<?php echo Html::beginForm(Url::to(['student/verify-two','id'=>$bmRecord->id]),'post',['id'=>'verifyStep2']);?>
					<textarea rows="5" cols="7" name="reasons2" placeholder="请填写审核理由"></textarea>
					<input type="hidden" name="isAgree" />
					<a href="javascript:;" class="btn-verify agree">同意</a>
					<a href="javascript:;" class="btn-verify disagree">不同意</a>
				<?php echo Html::endForm();?>
			<?php else :?>
				<?php echo $bmRecord->verifyReason2;?>
			<?php endif;?>
		</td>
	</tr>
</table>
<p><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
</div>

<?php 
$css = <<<CSS
table.studentInfo{
    border : 1px solid #3f3f3f;
}
table.studentInfo td{
    border : 1px solid #3f3f3f;
    padding:10px 20px;
}
table.studentInfo td.title{
    background:#f3f3f3;
    text-align: center
}
table.studentInfo td.verifyForm{text-align: left}
.verifyForm textarea{
    width: 700px;
    border: 1px solid #c5c59f;
	padding:2px;
}
.verifyForm a.btn-verify{
    display: inline-block;
    padding: 5px 20px;
    background: #2da3ea;
    border-radius: 5px;
    margin-left: 19px;
	color:#fff;
}
CSS;
$js = <<<JS
$(document).on('click','.agree,.disagree',function(){
	var textarea = $(this).parent().find('textarea');
	var reasons = $(textarea[0]).val();
	if(!reasons){
		alert('请输入审核理由');return;
	}
	var isAgree = 1;
	if($(this).hasClass('agree')){
		isAgree = 1;
	}else{
		isAgree = 0;
	}
	$(this).parent().find('input[name=isAgree]').val(isAgree);
	$(this).parent('form').submit();
})
JS;
$this->registerCss($css);
$this->registerJs($js);
?>