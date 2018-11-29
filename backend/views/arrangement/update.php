<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $arrangement \store\entities\Arrangement */
/* @var $model store\forms\manage\arrangement\ArrangementUpdateForm */

$this->title = $arrangement->song->name . ' ' . $arrangement->arrangementType->name;
$this->params['breadcrumbs'][] = ['label' => 'Аранжировки', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $arrangement->id]];
?>
<div class="song-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border">Описание аранжировки</div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Изображения</div>
                <div class="box-body">
                    <?php /** @var \yiidreamteam\upload\ImageUploadBehavior $arrangement */ ?>
                    <img src="<?= $arrangement->getThumbFileUrl('preview_image', 'small_list') ?>">
                    <?= $form->field($model, 'previewImage')->fileInput() ?>
                    <img src="<?= $arrangement->getThumbFileUrl('detail_image', 'thumb') ?>">
                    <?= $form->field($model, 'detailImage')->fileInput() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Песня</div>
                <div class="box-body">
                    <?= $form->field($model, 'songId')->dropDownList($model->songList()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Форматы</div>
                <div class="box-body">
                    <?= $form->field($model, 'formatsId')->dropDownList($model->formatsList()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Тип аранжировки</div>
                <div class="box-body">
                    <?= $form->field($model, 'arrangementTypeId')->dropDownList($model->arrangementTypeList()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Тип главного торгового предложения</div>
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
    </div>
    <div class="row">
        <?php foreach ($model->saleOffers as $i => $saleOffer): ?>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border"><h4><?= $saleOffer->getOfferType() ?></h4></div>
                    <div class="box-body">
                        <?= $form->field($saleOffer, "[{$i}]offerTypeId")->hiddenInput()->label(false) ?>
                        <?= $form->field($saleOffer, "[{$i}]price")->textInput() ?>
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
