<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\Artist;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Артист';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить нового артиста', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'preview_image',
                        'value' => function(Artist $model) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $model */
                            return $model->getThumbFileUrl('preview_image', 'thumb');
                        },
                        'format' => 'image',
                    ],
                    'name',
                    'slug',
                    'description',
                    [
                        'attribute' => 'genre',
                        'value' => function(Artist $artist) {
                            return implode(\yii\helpers\ArrayHelper::getColumn($artist->genres, 'name'), ', ');
                        }
                    ],
                    [
                        'attribute' => 'createdAt',
                        'value' => function(Artist $artist) {
                            return date('h:i:s d:m:Y', $artist->created_at);
                        }
                    ],
                    [
                        'attribute' => 'createdUser',
                        'value' => function(Artist $model) {
                            return $model->createdUser->username;
                        }
                    ],
                    [
                        'attribute' => 'updatedUser',
                        'value' => function(Artist $model) {
                            return $model->updatedUser->username;
                        }
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
