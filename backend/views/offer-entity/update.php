<?php

/* @var $this yii\web\View */
/* @var $offerEntity store\entities\OfferEntity */
/* @var $model store\forms\manage\offerEntity\OfferEntityForm */

$this->title = 'Изменение сущности предложения: ' . $offerEntity->name;
$this->params['breadcrumbs'][] = ['label' => 'Сущности предложений', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $offerEntity->name, 'url' => ['view', 'id' => $offerEntity->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
