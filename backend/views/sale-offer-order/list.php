<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\SaleOfferOrder;

/* @var $this yii\web\View */
/* @var $searchModel \store\forms\manage\saleOfferOrder\SaleOfferOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Купленые ноты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'email',
                    [
                        'attribute' => 'createdAt',
                        'value' => function(SaleOfferOrder $order) {
                            return date('h:i:s d:m:Y', $order->created_at);
                        },
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'saleOfferId',
                        'value' => function(SaleOfferOrder $order) {
                            return Html::a($order->saleOffer->offer->title(), $order->saleOffer->offer->url());
                        },
                        'format' => 'html',
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
