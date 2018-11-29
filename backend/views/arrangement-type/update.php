<?php

/* @var $this yii\web\View */
/* @var $offerEntity store\entities\ArrangementType */
/* @var $model store\forms\manage\arrangementType\ArrangementTypeForm */

$this->title = 'Изменение типа аранжировки: ' . $offerEntity->name;
$this->params['breadcrumbs'][] = ['label' => 'Тип аранжировки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $offerEntity->name, 'url' => ['view', 'id' => $offerEntity->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
