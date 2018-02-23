<?php


use yii\helpers\Html;

?>

<table class="studentInfo">
	<tr>
		<td class="title">姓名</td><td colspan="2"><?php echo Html::activeTextInput($model, 'trueName')?></td>
		<td class="title">姓别</td><td colspan="2"><?php echo Html::activeTextInput($model, 'sex')?></td>
		<td class="title">名族</td><td colspan="3"><?php echo Html::activeTextInput($model, 'nation')?></td>
		<td class="title">政治面貌</td><td colspan="2"><?php echo Html::activeTextInput($model, 'politicalStatus')?></td>
		<td class="title"  rowspan="4">头像</td><td colspan="4" rowspan="4" style="width: 120px;"><img alt="头像" src=""></td>
	</tr>
	<tr>
		<td class="title">出生年月</td><td colspan="2"><?php echo Html::activeTextInput($model, 'birthday')?></td>
		<td class="title">身份证号</td><td colspan="9"><?php echo Html::activeTextInput($model, 'IDnumber')?></td>
	</tr>
	<tr>
		<td class="title">联系电话</td><td colspan="2"><?php echo Html::activeTextInput($model, 'phone')?></td>
		<td class="title">现居城市</td><td colspan="2"><?php echo Html::activeTextInput($model, 'city')?></td>
		<td class="title">详细地址</td><td colspan="6"><?php echo Html::activeTextInput($model, 'address')?></td>
	</tr>
	<tr>
		<td class="title">毕业学校</td><td colspan="5"><?php echo Html::activeTextInput($model, 'graduationSchool')?></td>
		<td class="title">学历</td><td colspan="2"><?php echo Html::activeTextInput($model, 'eduation')?></td>
		<td class="title">毕业专业</td><td colspan="3"><?php echo Html::activeTextInput($model, 'graduationMajor')?></td>
	</tr>
	<tr>
		<td class="title" colspan="2">工作单位（公司）</td><td colspan="7"><?php echo Html::activeTextInput($model, 'company')?></td>
		<td class="title">职称</td><td colspan="3"><?php echo Html::activeTextInput($model, 'positionalTitles')?></td>
	    <td class="title">工作年限</td><td ><?php echo Html::activeTextInput($model, 'workYear')?></td>
	</tr>
	<tr style="height: 80px;">
		<td class="title" colspan="2">个人介绍</td><td colspan="14"><?php echo Html::activeTextarea($model, 'selfIntruduce')?></td>
	</tr>
	<tr>
		<td class="title" colspan="2">社院所学专业</td>
		<td colspan="14">
			<?php echo Html::activeTextInput($model, 'currentMajor')?>
		</td>
		
	</tr>
	<tr style="height: 80px;">
		<td class="title" colspan="2">社院在校情况</td>
		<td colspan="14">
			<?php echo Html::activeTextarea($model, 'situation')?>
		</td>
	</tr>
	<tr>
		<td class="title" colspan="2">现报名班级</td><td colspan="14"><?php echo Html::activeTextInput($model, 'gradeClass')?></td>
	</tr>
	<tr  style="height: 80px;">
		<td class="title" colspan="2">初始审核</td>
		<td colspan="14" class="verifyForm">
			同意
		</td>
	</tr>
	<tr  style="height: 80px;">
		<td class="title" colspan="2">二次审核</td>
		<td colspan="14" class="verifyForm">
			不同意
		</td>
	</tr>
</table>

<?php 
$css = <<<CSS
input, textarea, select, button {
    text-rendering: auto;
    color: initial;
    letter-spacing: normal;
    word-spacing: normal;
    text-transform: none;
    text-indent: 0px;
    text-shadow: none;
    display: inline;
    text-align: start;
    margin: 0em;
    font: 400 13.3333px Arial;
}
table {
    display: table;
    border-collapse: separate;
    border-spacing: 0px;
    border-color: none;
}
table.studentInfo{
    border : 1px solid #e0e0e0;
	margin:0 auto;
}
table.studentInfo td{
    /* border : 1px solid #e0e0e0;
    padding:10px 20px;
	border-spacing: 0px; */
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
    height: 34px;
    vertical-align: middle;
    font-family: "宋体";
    font-size: 14px;
    text-indent: 6px;
	padding-right: 5px;
}
table.studentInfo td.title{
    background:#f3f3f3;
	text-align: center;
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


$this->registerCss($css);
?>