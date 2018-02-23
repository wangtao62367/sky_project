<?php



use yii\helpers\Url;
use frontend\assets\LoginAsset;

?>

<div class="linkexprise">

	<p>当前链接已经失效，请<a href="<?php echo Url::to(['user/findpwdbymail']);?>">重新发送邮件</a>获取链接。</p>

</div>
<?php 
LoginAsset::addCss($this, '/front/css/findpwdbymail.css');
?>