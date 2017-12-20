<?php
use backend\assets\AppLoginAsset;
use yii\helpers\Html;
AppLoginAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode('社会主义学院后台管理-' . $this->title); ?></title>
    <?php $this->head() ?>
    <style>
        
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="div-form">
	<h4 class="title">社会主义学院-后台管理系统</h4>
	<hr class="diliver"/>
	<?php echo $content; ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

