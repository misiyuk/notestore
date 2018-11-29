<?php

/* @var $this yii\web\View */
/* @var $order store\entities\Order */
/* @var $model store\forms\manage\order\OrderForm */

$this->title = 'Изменение заказа: ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $order->id, 'url' => ['view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
