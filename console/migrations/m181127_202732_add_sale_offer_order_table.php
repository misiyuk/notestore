<?php

use yii\db\Migration;

/**
 * Class m181127_202732_add_sale_offer_order_table
 */
class m181127_202732_add_sale_offer_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%sale_offer_order}}', [
            'id' => $this->primaryKey(),
            'sale_offer_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-sale_offer_order-sale_offer_id}}', '{{%sale_offer_order}}', 'sale_offer_id');
        $this->createIndex('{{%idx-sale_offer_order-email}}', '{{%sale_offer_order}}', 'email');
        $this->addForeignKey(
            'fk-sale_offer_order-sale_offer_id',
            '{{%sale_offer_order}}',
            'sale_offer_id',
            '{{%sale_offer}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sale_offer_order-sale_offer_id', '{{%sale_offer_order}}');
        $this->dropTable('{{%sale_offer_order}}');
    }
}
