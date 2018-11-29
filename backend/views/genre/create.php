<?php

/* @var $this yii\web\View */
/* @var $model store\forms\manage\GenreForm */

$this->title = 'Создание жанра';
$this->params['breadcrumbs'][] = ['label' => 'Жанры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
