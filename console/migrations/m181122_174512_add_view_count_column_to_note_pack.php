<?php

use yii\db\Migration;
use store\entities\NotePack;

/**
 * Class m181122_174512_add_view_count_column_to_note_pack
 */
class m181122_174512_add_view_count_column_to_note_pack extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(NotePack::tableName(), 'view_count', 'INT DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(NotePack::tableName(), 'view_count');
    }
}
