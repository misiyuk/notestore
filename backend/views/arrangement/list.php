<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\Arrangement;

/* @var $this yii\web\View */
/* @var $searchModel \store\forms\manage\arrangement\ArrangementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аранжировки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить новую аранжировку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'slug',
                    'year',
                    [
                        'attribute' => 'song',
                        'label' => 'Song',
                        'value' => function(Arrangement $model) {
                            return $model->song->name;
                        },
                        'filter' => $searchModel->songList(),
                        'sortLinkOptions' => ['song'],
                    ],
                    [
                        'attribute' => 'arrangementType',
                        'label' => 'Arrangement type',
                        'value' => function(Arrangement $model) {
                            return $model->arrangementType->name;
                        },
                        'filter' => $searchModel->arrangementTypeList(),
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
