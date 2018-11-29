<?php

/* @var $this yii\web\View */
/* @var $model store\forms\manage\arrangementType\ArrangementTypeForm */

$this->title = 'Создание типа аранжировки';
$this->params['breadcrumbs'][] = ['label' => 'Типы аранжировок', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
