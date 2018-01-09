<?php

use common\publics\MyHelper;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="/admin/images/sun.png" alt="天气" /></span>
    <b><?php echo $user->account;?> 早上好，欢迎使用社会主义后台管理系统</b>
    <a href="<?php echo Url::to(['admin/edit','id'=>$user->id])?>">帐号设置</a>
    </div>
    
    <div class="welinfo">
    <span><img src="/admin/images/time.png" alt="时间" /></span>
    <i>您上次登录的时间： <?php echo MyHelper::timestampToDate($user->modifyTime);?>(登陆IP：<?php echo long2ip($user->loginIp)?>)</i> （不是您登录的？<a href="<?php echo Url::to(['admin/editpwd','id'=>$user->id])?>">请点这里</a>）
    </div>
    
    <!-- <div class="xline"></div>
    
    <ul class="iconlist">
    
    <li><img src="/admin/images/ico01.png" /><p><a href="#">管理设置</a></p></li>
    <li><img src="/admin/images/ico02.png" /><p><a href="#">发布文章</a></p></li>
    <li><img src="/admin/images/ico03.png" /><p><a href="#">数据统计</a></p></li>
    <li><img src="/admin/images/ico04.png" /><p><a href="#">文件上传</a></p></li>
    <li><img src="/admin/images/ico05.png" /><p><a href="#">目录管理</a></p></li>
    <li><img src="/admin/images/ico06.png" /><p><a href="#">查询</a></p></li> 
            
    </ul>
    
    <div class="ibox"><a class="ibtn"><img src="/admin/images/iadd.png" />添加新的快捷功能</a></div> -->
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="/admin/images/dp.png" alt="提醒" /></span>
    <b>信息管理系统使用指南</b>
    </div>
    
    <ul class="infolist">
    <li><span>您可以快速进行新闻发布或管理操作</span><a class="ibtn" href="<?php echo Url::to(['article/articles'])?>">发布或管理新闻</a></li>
    <li><span>您可以快速发布或管理测评试卷</span><a class="ibtn" href="<?php echo Url::to(['testpaper/manage'])?>">发布或管理试卷</a></li>
    <li><span>您可以进行用户密码重置、用户设置等操作</span><a class="ibtn" href="<?php echo Url::to(['user/manage'])?>">用户管理</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="info"><b>最近一个月用户数据统计数据展示</b></div>
    
    <!-- <ul class="umlist">
    <li><a href="#">如何发布文章</a></li>
    <li><a href="#">如何访问网站</a></li>
    <li><a href="#">如何管理广告</a></li>
    <li><a href="#">后台用户设置(权限)</a></li>
    <li><a href="#">系统设置</a></li>
    </ul> -->
    
    
    </div>
