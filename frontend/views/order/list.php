<?php
/**
 * @var \yii\web\View $this
 * @var \store\entities\SaleOfferOrder[] $saleOfferOrders
 */
use yii\helpers\Url;
?>
<div class="order-form-block">
    <div class="breadcrumbs">
        <div class="container clearfix">
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>">Главная</a>
            →
            <span>Заказ нот</span>
        </div>
    </div>
    <div class="workarea order-form">
        <div class="container">
            <h1>Список сделаных заказов</h1>
            <div class="order-form_wrap">
                <?php foreach ($saleOfferOrders as $saleOfferOrder): ?>
                    <a href="<?= $saleOfferOrder->saleOffer->offer->url() ?>">
                        <?= $saleOfferOrder->saleOffer->offer->title() ?>
                    </a>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>