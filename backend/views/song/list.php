<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\Song;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\GenreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Композиции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-index">

    <p>
        <?= Html::a('Добавить новую композиции', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'name',
                    [
                        'attribute' => 'created_at',
                        'value' => function(Song $song) {
                            return date('H:i:s d:m:Y', $song->created_at);
                        }
                    ],
                    [
                        'attribute' => 'createdUser',
                        'value' => function (Song $model) {
                            return $model->createdUser->username;
                        },
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function(Song $song) {
                            return date('H:i:s d:m:Y', $song->updated_at);
                        }
                    ],
                    [
                        'attribute' => 'updatedUser',
                        'value' => function (Song $model) {
                            return $model->updatedUser->username;
                        },
                    ],
                    [
                        'attribute' => 'audio',
                        'value' => function(\store\entities\Song $song) {
                            /** @var \yiidreamteam\upload\FileUploadBehavior $song */
                            return Html::a('скачать', $song->getUploadedFileUrl('audio'));
                        },
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'text',
                        'value' => function(\store\entities\Song $song) {
                            return \yii\helpers\StringHelper::truncateWords(strip_tags($song->text), 10);
                        },
                        'format' => 'html',
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
