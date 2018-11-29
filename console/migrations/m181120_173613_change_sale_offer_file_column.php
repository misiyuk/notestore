<?php

use yii\db\Migration;
use store\entities\SaleOffer;
use store\entities\File;

/**
 * Class m181120_173613_change_sale_offer_file_column
 */
class m181120_173613_change_sale_offer_file_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-sale_offer-file_id}}', SaleOffer::tableName());
        $this->dropColumn(SaleOffer::tableName(), 'file_id');
        $this->addColumn(SaleOffer::tableName(), 'file', 'varchar(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(SaleOffer::tableName(), 'file');
        $this->addColumn(SaleOffer::tableName(), 'file_id', 'integer(11)');
        $this->createIndex('{{%idx-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id');
        $this->addForeignKey('{{%fk-sale_offer-file_id}}', SaleOffer::tableName(), 'file_id', File::tableName(), 'id');
    }
}
