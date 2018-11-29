<?php

/* @var $this yii\web\View */
/* @var $model store\forms\manage\offerType\OfferTypeForm */

$this->title = 'Создание типа предложений';
$this->params['breadcrumbs'][] = ['label' => 'Типы предложений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
