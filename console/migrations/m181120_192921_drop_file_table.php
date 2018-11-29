<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `file`.
 */
class m181120_192921_drop_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%file}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id');
        $this->addForeignKey('{{%fk-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id', '{{%file}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
