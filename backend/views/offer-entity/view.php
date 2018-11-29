<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $offerEntity store\entities\OfferEntity */

$this->title = $offerEntity->name;
$this->params['breadcrumbs'][] = ['label' => 'Нотные наборы', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $offerEntity->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $offerEntity->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Нотный набор</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $offerEntity,
                'attributes' => [
                    'id',
                    'name',
                ],
            ]) ?>
        </div>
    </div>
</div>
