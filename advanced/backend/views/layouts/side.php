<?php
use backend\assets\AppSideAsset;
use yii\helpers\Html;
AppSideAsset::register($this);
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
</head>
<body>
<?php $this->beginBody() ?>

<?php echo $content; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

