<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model store\forms\manage\notePack\NotePackCreateForm */

$this->title = 'Создать композицию';
$this->params['breadcrumbs'][] = ['label' => 'Артисты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border">Описание исполнителя</div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'previewImage')->fileInput() ?>
                    <?= $form->field($model, 'detailImage')->fileInput() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">Арранжировки</div>
                <div class="box-body">
                    <?= $form->field($model, 'arrangementIds')->checkboxList($model->arrangementList()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Главное торговое предложение</div>
                <div class="box-body">
                    <?= $form->field($model, 'offerTypeId')->dropDownList($model->offerTypeList()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3> Торговые предложения</h3>
                </div>
            </div>
        </div>
        <?php foreach ($model->saleOffers as $i => $saleOffer): ?>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border"><h4><?= $saleOffer->getOfferType() ?></h4></div>
                    <div class="box-body">
                        <?= $form->field($saleOffer, "[{$i}]offerTypeId")->hiddenInput()->label(false) ?>
                        <?= $form->field($saleOffer, "[{$i}]file")->fileInput() ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
