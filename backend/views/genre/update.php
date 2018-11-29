<?php

/* @var $this yii\web\View */
/* @var $genre store\entities\Genre */
/* @var $model store\forms\manage\GenreForm */

$this->title = 'Изменение жанра: ' . $genre->name;
$this->params['breadcrumbs'][] = ['label' => 'Жанры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $genre->name, 'url' => ['view', 'id' => $genre->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
