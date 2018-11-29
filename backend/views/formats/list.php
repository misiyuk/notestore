<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\Film;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\GenreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Форматы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить новые форматы', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
