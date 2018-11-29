<?php

use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\artist\ArtistForm */
/* @var $artist \store\entities\Artist|\yiidreamteam\upload\ImageUploadBehavior */

$this->title = 'Изменить исполнителя';
$this->params['breadcrumbs'][] = ['label' => 'Артисты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border">Описание исполнителя</div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->widget(CKEditor::class) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Изображения</div>
                <div class="box-body">
                    <img src="<?= $artist->getThumbFileUrl('preview_image', 'thumb') ?>">
                    <?= $form->field($model, 'previewImage')->fileInput() ?>
                    <img src="<?= $artist->getThumbFileUrl('detail_image', 'detail') ?>">
                    <?= $form->field($model, 'detailImage')->fileInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Жанры</div>
                <div class="box-body">
                    <?= $form->field($model, 'genreIds')->checkboxList($model->genreList()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
