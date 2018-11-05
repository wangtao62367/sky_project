<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\BmRecord;

$this->title = '我要报名-查看报名信息';
?>

<img class="main-banner top-banner" src="/front/img/abouSchool/top.jpg"/>
<div class="main">
<div class="navigation">
	<ul>
		<li><a href="javascript:;" class="news">个人中心</a></li>
		
		<li><a href="<?php echo Url::to(['user/center']); ?>" class="UnitedFront">我的报名</a></li>
		
		<li><a href="<?php echo Url::to(['user/info']); ?>" >我的信息</a></li>
		
		<li><a href="<?php echo Url::to(['user/edit-pwd']);?>"  >修改密码</a></li>
		
		<li><a href="<?php echo Url::to(['news/list-by-catecode','code'=>'wybm']);?>">我要报名</a></li>

	</ul>
</div>
<div class="content">
    <div class="caption">
    	<h2><?php echo $this->title;?></h2>
    </div>
    <div class="_hr">
        <hr class="first"/><hr class="second"/>
    </div>

    <div class="text" >
    	<div id="bminfoArea" style="padding-top: 10px;">
    	<style>
            table {
                border-collapse: collapse;
                width:700px;height:978px;
                margin:0 auto;
            }
            
            table, td, th {
                border: 1px solid #333;
                text-align:left;
                padding-left:10px;
                height:40px;
                min-width:80px;
            }
            table input,textarea{outline:none;border:none;padding:8px;box-sizing: border-box;min-width:200px;width:100%;height: 40px;}
            table .title{
                font-weight:700;
                text-align:center;
            }
            .avater-box{
                width:160px;
                height:240px;
                margin:0 auto;
                text-align:center;
                line-height:120px;
                border:1px solid #333;
                border-style: dotted;
                border-radius: 5px;
                cursor: pointer;
            }
            
            .bminfo .maxrow{height:60px;}
            .bminfo td .avater{display:block;margin: auto;border-radius: 5px;}
            td .verify-status{color:red;font-weight:700;}
        </style>
        <table class="bminfo">
            <tr class="maxrow">
            	<td class="title">审核状态</td>
            	<td colspan="6">
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
				
				<td rowspan="3" style="padding-left:5px;padding-right:5px;">
					<div class="avater-box" id="avater-upload">
						<img width="160px" height="240px" src="<?php echo $info['avater'];?>" />
					</div>
					<p class="form-error"></p>
				</td>
			</tr>
			
			<tr>
				<td class="title">政治面貌</td>
				<td>
					<?php echo $info['political']?>
				</td>
				
				<td class="title">民族</td>
				<td>
					<?php echo $info['nation'];?>
				</td>
				
				<td class="title">健康状况</td>
				<td>
					<?php echo $info['health'];?>
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
        
        
        </table>
    		
    	</div>	
    	<div style="width: 700px;margin:0 auto;text-align:center;margin-top:25px;margin-bottom:30px;">
    	  <?php if($info['verify'] > 0):?>
          	<a href="javascript:;" class="print-btn">打印</a>
          <?php else:?>
          	<a href="<?php echo Url::to(['student/joinup','cid'=>$info['gradeClassId']]);?>" class="print-btn">重新申报</a>
          <?php endif;?>
        </div>
    </div>
</div>
<div style="clear: both"></div>
</div>



<?php 
AppAsset::addCss($this, '/front/css/newsUnitedFront.css');
AppAsset::addScript($this, '/front/js/jquery.PrintArea.js');
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
.print-btn{
    background: #009688;
    color: #fff;
    padding: 8px 25px;
    border-radius: 4px;
}
.print-btn:hover{background: #0e736a;}
CSS;
$js= <<<JS
$(document).on('click','.print-btn',function(){
    $("div#bminfoArea").printArea(); 
})

JS;

$this->registerJs($js);
$this->registerCss($css);
?>