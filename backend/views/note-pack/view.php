<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\entities\NotePack;

/* @var $this yii\web\View */
/* @var $notePack NotePack */

$this->title = $notePack->name;
$this->params['breadcrumbs'][] = ['label' => 'Нотные наборы', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $notePack->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $notePack->id], [
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
                'model' => $notePack,
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                    'discount',
                    'description',
                    [
                        'label' => 'Preview image',
                        'value' => function(NotePack $notePack) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $notePack */
                            return $notePack->getThumbFileUrl('preview_image', 'thumb');
                        },
                        'format' => 'image',
                    ],
                    [
                        'label' => 'Detail image',
                        'value' => function(NotePack $notePack) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $notePack */
                            return $notePack->getThumbFileUrl('detail_image', 'thumb');
                        },
                        'format' => 'image',
                    ],
                    [
                        'label' => 'Главное торговое предложение',
                        'value' => 'mainOfferType.name',
                    ],
                    [
                        'label' => 'Создано',
                        'value' => "{$notePack->createdUser->username} (" . date('Y-m-d H:i:s', $notePack->created_at) . ")",
                    ],
                    [
                        'label' => 'Последнее обновление',
                        'value' => "{$notePack->updatedUser->username} (" . date('Y-m-d H:i:s', $notePack->updated_at) . ")",
                    ]
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border"><h4>Аранжировки</h4></div>
                    <div class="box-body">
                        <?php foreach ($notePack->arrangements as $arrangement): ?>
                        <p>
                            <?= Html::a($arrangement->arrangementName, ['arrangement/view', 'id' => $arrangement->id]) ?>
                        </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <?php foreach ($notePack->saleOffers as $saleOffer): ?>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border"><h4><?= $saleOffer->offerType->name ?></h4></div>
                    <div class="box-body">
                        <p>
                            Цена: <?= Yii::$app->formatter->asCurrency($saleOffer->price) ?>
                        </p>
                        <p>
                            <?php /** @var \yiidreamteam\upload\FileUploadBehavior $saleOffer */ ?>
                            Файл: <?= Html::a('Скачать', $saleOffer->getUploadedFileUrl('file')) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
