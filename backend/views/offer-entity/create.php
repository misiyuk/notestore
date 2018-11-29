<?php

/* @var $this yii\web\View */
/* @var $model store\forms\manage\offerEntity\OfferEntityForm */

$this->title = 'Создание типа предложений';
$this->params['breadcrumbs'][] = ['label' => 'Сущности предложений', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
