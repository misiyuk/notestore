<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\NotePack;

/* @var $this yii\web\View */
/* @var $searchModel \store\forms\manage\notePack\NotePackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Нотные наборы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить новый нотный набор', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'preview_image_id',
                        'value' => function(NotePack $model) {
                            /** @var \yiidreamteam\upload\ImageUploadBehavior $model */
                            return $model->getThumbFileUrl('preview_image', 'cart');
                        },
                        'format' => 'image',
                        'filter' => false,
                    ],
                    'name',
                    'slug',
                    'discount',
                    [
                        'attribute' => 'description',
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
