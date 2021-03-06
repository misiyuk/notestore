<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\formats\FormatsForm */

$this->title = 'Создать форматы';
$this->params['breadcrumbs'][] = ['label' => 'Форматы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-update">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
