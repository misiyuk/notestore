<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $film store\entities\Film */

$this->title = $film->name;
$this->params['breadcrumbs'][] = ['label' => 'Фильм', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $film->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $film->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Фильм</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $film,
                'attributes' => [
                    'id',
                    'name',
                    [
                        'label' => 'Создано',
                        'value' => "{$film->createdUser->username} (" . date('Y-m-d H:i:s', $film->created_at) . ")",
                    ],
                    [
                        'label' => 'Последнее обновление',
                        'value' => "{$film->updatedUser->username} (" . date('Y-m-d H:i:s', $film->updated_at) . ")",
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>
