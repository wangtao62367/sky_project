<?php

use yii\helpers\Url;
use common\models\CategoryType;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
	    <li><a href="javascript:;">网站管理系统</a></li>
	    <li><a href="<?php Url::to(['content/schoole'])?>">内容管理</a></li>
    </ul>
</div>
    
<div class="formbody">
	
    
    <div class="toolsli">
    	<h4>学院基本信息录入</h4>
	    <ul class="toollist">
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::XYJJ])?>"><img src="/admin/images/i06.png" /></a><h2>学院简介</h2></li>
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::FZLC])?>"><img src="/admin/images/i06.png"  width="65px"/></a><h2>发展历程</h2></li>
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::ZZJG])?>"><img src="/admin/images/i06.png"/></a><h2>组织机构</h2></li> 
		    <li><a href="<?php echo Url::to(['personage/manage','Personage[search][role]'=>'kzjs'])?>"><img src="/admin/images/i07.png" width="65px"/></a><h2>客座教授</h2></li>  
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::XRLD])?>"><img src="/admin/images/i06.png"/></a><h2>现任领导</h2></li> 
		    <li><a href="<?php echo Url::to(['personage/manage','Personage[search][role]'=>'szqk'])?>"><img src="/admin/images/i07.png" width="65px"/></a><h2>师资情况</h2></li>  
		    <li><a href="<?php echo Url::to(['personage/manage','Personage[search][role]'=>'xyfc'])?>"><img src="/admin/images/i07.png" width="65px"/></a><h2>学员风采</h2></li> 
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::QQGH])?>"><img src="/admin/images/i06.png" width="65px"/></a><h2>亲切关怀</h2></li>  
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::GWWYH])?>"><img src="/admin/images/i06.png" width="65px"/></a><h2>院务委员会</h2></li>  
		    <li><a href="<?php echo Url::to(['image/add'])?>"><img src="/admin/images/d05.png" width="65px"/></a><h2>社院风光</h2></li>  
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::XYDZ])?>"><img src="/admin/images/i06.png" width="65px"/></a><h2>学院地址</h2></li>       
	    </ul>
	   
    </div>
    <div class="toolsli">
    	 <h4>智库中心信息录入</h4>
	    <ul class="toollist">
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::ZKZX])?>"><img src="/admin/images/i06.png" /></a><h2>智库简介</h2></li>     
	    </ul>
    </div>
    
    <div class="toolsli">
    	 <h4>文化学院信息录入</h4>
	    <ul class="toollist">
		    <li><a href="<?php echo Url::to(['schoole/edit','type'=>CategoryType::WHXYJJ])?>"><img src="/admin/images/i06.png" /></a><h2>学院简介</h2></li>     
	    </ul>
    </div>
</div>

<?php 
$css=<<<CSS
.toolsli h4{font-size:20px;margin:20px;}
CSS;
$this->registerCss($css);
?>