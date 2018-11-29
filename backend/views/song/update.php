<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model store\forms\manage\song\SongEditForm */

$this->title = 'Изменить композицию';
$this->params['breadcrumbs'][] = ['label' => 'Композиции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border">Описание композиции</div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'audio')->fileInput() ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'text')->widget(CKEditor::className()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Жанры</div>
                <div class="box-body">
                    <?= $form->field($model->genres, 'ids')->checkboxList($model->genres->genreList()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Артисты</div>
                <div class="box-body">
                    <?= $form->field($model->artists, 'ids')->checkboxList($model->artists->artistList()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Фильмы</div>
                <div class="box-body">
                    <?= $form->field($model->films, 'ids')->checkboxList($model->films->filmList()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
