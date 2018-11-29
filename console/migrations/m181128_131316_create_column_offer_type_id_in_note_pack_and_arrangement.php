<?php

use yii\db\Migration;

/**
 * Class m181128_131316_create_column_offer_type_id_in_note_pack_and_arrangement
 */
class m181128_131316_create_column_offer_type_id_in_note_pack_and_arrangement extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%note_pack}}', 'offer_type_id', $this->integer()->defaultValue(1)->notNull());
        $this->addColumn('{{%arrangement}}', 'offer_type_id', $this->integer()->defaultValue(1)->notNull());
        $this->createIndex('idx-note_pack-offer_type_id', '{{%note_pack}}', 'offer_type_id');
        $this->createIndex('idx-arrangement-offer_type_id', '{{%arrangement}}', 'offer_type_id');
        $this->addForeignKey('fk-note_pack-offer_type_id', '{{%note_pack}}', 'offer_type_id', 'offer_type', 'id');
        $this->addForeignKey('fk-arrangement-offer_type_id', '{{%arrangement}}', 'offer_type_id', 'offer_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-note_pack-offer_type_id', '{{%note_pack}}');
        $this->dropForeignKey('fk-arrangement-offer_type_id', '{{%arrangement}}');
        $this->dropColumn('{{%note_pack}}', 'offer_type_id');
        $this->dropColumn('{{%arrangement}}', 'offer_type_id');
    }
}
