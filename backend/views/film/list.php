<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\Film;

/* @var $this yii\web\View */
/* @var $searchModel \store\forms\manage\film\FilmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фильмы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить новый фильм', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Film $model) {
                            return date('h:i:s d:m:Y', $model->created_at);
                        },
                    ],
                    [
                        'attribute' => 'createdUser',
                        'value' => function(Film $model) {
                            return $model->createdUser->username;
                        },
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function(Film $model) {
                            return date('h:i:s d:m:Y', $model->updated_at);
                        },
                    ],
                    [
                        'attribute' => 'updatedUser',
                        'value' => function(Film $model) {
                            return $model->updatedUser->username;
                        },
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
