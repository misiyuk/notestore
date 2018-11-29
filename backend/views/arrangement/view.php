<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\entities\Arrangement;

/* @var $this yii\web\View */
/* @var $arrangement store\entities\Arrangement */
/* @var $filmsProvider \yii\data\ActiveDataProvider */

$this->title = $arrangement->song->name;
$this->params['breadcrumbs'][] = ['label' => 'Арранжировки', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $arrangement->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $arrangement->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Арранжировка</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $arrangement,
                'attributes' => [
                    'id',
                    'slug',
                    'year',
                    [
                        'attribute' => 'preview_picture',
                        'value' => function(Arrangement $model) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $model */
                            return $model->getThumbFileUrl('preview_image', 'small_list');
                        },
                        'format' => 'image',
                    ],
                    [
                        'attribute' => 'preview_picture',
                        'value' => function(Arrangement $model) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $model */
                            return $model->getImageFileUrl('detail_image');
                        },
                        'format' => 'image',
                    ],
                    [
                        'attribute' => 'song.name',
                        'label' => 'Название композиции',
                    ],
                    [
                        'attribute' => 'arrangementType.name',
                        'label' => 'Тип арранжировки',
                    ],
                    [
                        'attribute' => 'mainSaleOffer.offerType.name',
                        'label' => 'Тип главного торгового предложения',
                    ],
                    [
                        'attribute' => 'formats.name',
                        'label' => 'Форматы',
                    ],
                    [
                        'label' => 'Создано',
                        'value' => "{$arrangement->createdUser->username} (" . date('Y-m-d H:i:s', $arrangement->created_at) . ")",
                    ],
                    [
                        'label' => 'Последнее обновление',
                        'value' => "{$arrangement->updatedUser->username} (" . date('Y-m-d H:i:s', $arrangement->updated_at) . ")",
                    ]
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <?php foreach ($arrangement->saleOffers as $saleOffer): ?>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border"><h4><?= $saleOffer->offerType->name ?></h4></div>
                    <div class="box-body">
                        <p>
                            Цена: <?= Yii::$app->formatter->asCurrency($saleOffer->price) ?>
                        </p>
                        <p>
                            <?php /** @var \yiidreamteam\upload\FileUploadBehavior $saleOffer */?>
                            Файл: <?= Html::a('Скачать', $saleOffer->getUploadedFileUrl('file')) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
