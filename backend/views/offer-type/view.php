<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $offerType store\entities\OfferType */

$this->title = $offerType->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы предложений', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $offerType->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $offerType->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $offerType,
                'attributes' => [
                    'id',
                    'name',
                ],
            ]) ?>
        </div>
    </div>
</div>
