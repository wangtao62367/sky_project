<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\BmRecord;


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
				<td class="title">姓名</td>
				<td>
					<?php echo $info['trueName'];?>
				</td>
				
				<td class="title">性别</td>
				<td>
					<?php echo $info['sex'] == 1 ? '男' : '女';?>
				</td>
				
				<td class="title">出生年月</td>
				<td>
					<?php echo $info['birthday'];?>
				</td>
				
				<td rowspan="3">
					<div class="avater-box" id="avater-upload">
						<img width="120px" height="120px" src="<?php echo $info['avater'];?>" />
					</div>
					<p class="form-error"></p>
				</td>
			</tr>
			
			<tr>
				<td class="title">党派</td>
				<td>
					<?php echo $info['political']?>
				</td>
				
				<td class="title">民族</td>
				<td>
					<?php echo $info['nation'];?>
				</td>
				
				<td class="title">健康状况</td>
				<td>
					<?php echo BmRecord::$health_texts[$info['health']];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">文化程度</td>
				<td>
					<?php echo $info['eduDegree'];?>
				</td>
				
				<td class="title">特长</td>
				<td colspan="3">
					<?php echo $info['speciality'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">参加工作时间</td>
				<td>
					<?php echo $info['dateToWork'];?>
				</td>
				
				<td class="title">参加党派时间</td>
				<td colspan="2">
					<?php echo $info['dateToPolitical'];?>
				</td>
				
				<td class="title">级别</td>
				<td>
					<?php echo $info['politicalGrade'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">工作单位</td>
				<td colspan="4">
					<?php echo $info['workplace'];?>
				</td>
				
				<td class="title">职务及职称</td>
				<td colspan="3">
					<?php echo $info['workDuties'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">组织机构</td>
				<td colspan="3">
					<?php echo $info['orgCode'];?>
				</td>
				
				<td class="title">身份证号码</td>
				<td colspan="2">
					<?php echo $info['IDnumber'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title" rowspan="2">通讯地址</td>
				<td colspan="4" rowspan="2">
					<?php echo $info['address'];?>
				</td>
				
				<td class="title">邮编</td>
				<td>
					<?php echo $info['postcode'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">电话</td>
				<td>
					<?php echo $info['phone'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">社会职务</td>
				<td colspan="3">
					<?php echo $info['socialDuties'];?>
				</td>
				
				<td class="title">党派职务</td>
				<td colspan="2">
					<?php echo $info['politicalDuties'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">简历</td>
				<td colspan="6">
					<?php echo $info['introduction'];?>
				</td>
			</tr>
			
			<tr>
				<td class="title">推荐单位</td>
				<td colspan="4">
					<?php echo $info['recommend'];?>
				</td>
				
				<td class="title">市州</td>
				<td >
					<?php echo $info['citystate'];?>
				</td>
			</tr>

	
	<tr>
		<td class="title" >初始审核</td>
		<td colspan="6" class="verifyForm">
			<?php if($info->verify == 1):?>
				<?php echo Html::beginForm(Url::to(['student/verify-one','id'=>$info->id]),'post',['id'=>'verifyStep1']);?>
					<textarea rows="5" cols="7" name="reasons1" placeholder="请填写审核理由"></textarea>
					<input type="hidden" name="isAgree" />
					<a href="javascript:;" class="btn-verify agree">同意</a>
					<a href="javascript:;" class="btn-verify disagree">不同意</a>
				<?php echo Html::endForm();?>
			<?php else :?>
				<?php echo $info->verifyReason1;?>
			<?php endif;?>
		</td>
	</tr>
	<tr>
		<td class="title" >二次审核</td>
		<td colspan="6" class="verifyForm">
			<?php if($info->verify == 2):?>
				<?php echo Html::beginForm(Url::to(['student/verify-two','id'=>$info->id]),'post',['id'=>'verifyStep2']);?>
					<textarea rows="5" cols="7" name="reasons2" placeholder="请填写审核理由"></textarea>
					<input type="hidden" name="isAgree" />
					<a href="javascript:;" class="btn-verify agree">同意</a>
					<a href="javascript:;" class="btn-verify disagree">不同意</a>
				<?php echo Html::endForm();?>
			<?php else :?>
				<?php echo $info->verifyReason2;?>
			<?php endif;?>
		</td>
	</tr>
</table>
<p><?php if(Yii::$app->session->hasFlash('error')){echo Yii::$app->session->getFlash('error');}?></p>
</div>

<?php 
$css = <<<CSS

table {
    border-collapse: collapse;
    width:890px;
    margin:0 auto;
}

table, td, th {
    border: 1px solid #333;
    text-align:left;
    padding-left:10px;
    padding-top:10px;
    padding-bottom:10px;
    height:60px;
    min-width:80px;
}
table input,textarea{outline:none;border:none;padding:8px;box-sizing: border-box;min-width:200px;width:100%;height: 50px;}
table .title{
    font-weight:700;
    text-align:center;
}
.avater-box{
    width:120px;
    height:120px;
    margin:0 auto;
    text-align:center;
    line-height:120px;
    border:1px solid #333;
    border-style: dotted;
    border-radius: 5px;
    cursor: pointer;
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