<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $song store\entities\Song */
/* @var $arrangementTypesProvider \yii\data\ActiveDataProvider */
/* @var $artistsProvider \yii\data\ActiveDataProvider */
/* @var $genresProvider \yii\data\ActiveDataProvider */
/* @var $filmsProvider \yii\data\ActiveDataProvider */

$this->title = $song->name;
$this->params['breadcrumbs'][] = ['label' => 'Композиции', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $song->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $song->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Песня</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $song,
                'attributes' => [
                    'id',
                    'name',
                    'text',
                    'video',
                    [
                        'attribute' => 'audio',
                        'value' => function(\store\entities\Song $song) {
                            /** @var \yiidreamteam\upload\FileUploadBehavior $song */
                            return Html::a('скачать', $song->getUploadedFileUrl('audio'));
                        },
                        'format' => 'html',
                    ],
                    [
                        'label' => 'Создано',
                        'value' => "{$song->createdUser->username} (" . date('Y-m-d H:i:s', $song->created_at) . ")",
                    ],
                    [
                        'label' => 'Последнее обновление',
                        'value' => "{$song->updatedUser->username} (" . date('Y-m-d H:i:s', $song->updated_at) . ")",
                    ]
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Жанры</div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $genresProvider,
                'columns' => [
                    'name',
                ],
                'layout' => "{items}",
            ]); ?>
        </div>
    </div>
    <?php if($song->getArrangementTypes()->count()): ?>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $arrangementTypesProvider,
                'columns' => [
                    'name',
                ],
                'layout' => "{items}",
            ]); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="box">
        <div class="box-header with-border">Артисты</div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $artistsProvider,
                'columns' => [
                    'name',
                ],
                'layout' => "{items}",
            ]); ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Фильмы</div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $filmsProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'label' => 'Название',
                    ],
                ],
                'layout' => "{items}",
            ]); ?>
        </div>
    </div>
</div>
