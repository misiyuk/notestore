<?php

/* @var $this yii\web\View */
/* @var $offerType store\entities\OfferType */
/* @var $model store\forms\manage\offerType\OfferEntityForm */

$this->title = 'Изменение типа предложений: ' . $offerType->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы предложений', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $offerType->name, 'url' => ['view', 'id' => $offerType->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
