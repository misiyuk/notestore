<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
\frontend\assets\CabinetAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">
<div class="wrap">

    <?php $this->beginBody() ?>

    <div class="container">
        <?= \common\widgets\Alert::widget() ?>
        <?= $content ?>
    </div>
    <?php $this->endBody() ?>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
</body>
</html>
<?php $this->endPage() ?>
