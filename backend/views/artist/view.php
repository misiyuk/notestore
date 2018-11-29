<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\entities\Artist;

/* @var $this yii\web\View */
/* @var $artist store\entities\Artist */

$this->title = $artist->name;
$this->params['breadcrumbs'][] = ['label' => 'Композиции', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $artist->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $artist->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Исполнитель</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $artist,
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                    'description',
                    [
                        'attribute' => 'preview_image',
                        'label' => 'Preview image',
                        'value' => function(Artist $artist) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $artist */
                            return $artist->getThumbFileUrl('preview_image', 'thumb');
                        },
                        'format' => 'image',
                    ],
                    [
                        'attribute' => 'detail_image',
                        'label' => 'Detail image',
                        'value' => function(Artist $artist) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $artist */
                            return $artist->getThumbFileUrl('detail_image', 'detail');
                        },
                        'format' => 'image',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <?php if (count($artist->genres)): ?>
    <div class="box">
        <div class="box-header with-border">Жанры</div>
        <div class="box-body">
            <ul>
            <?php foreach ($artist->genres as $genre): ?>
                <li><?= $genre->name ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>
