<?php

use yii\db\Migration;
use store\entities\SaleOffer;

/**
 * Class m181120_180959_change_sale_offer_price_type
 */
class m181120_180959_change_sale_offer_price_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(SaleOffer::tableName(), 'price', 'float(9,2)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(SaleOffer::tableName(), 'price', 'integer(11)');
    }
}
