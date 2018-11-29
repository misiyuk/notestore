<?php

use yii\db\Migration;
use store\entities\Arrangement;

/**
 * Class m181122_151822_add_view_count_column_to_arrangement
 */
class m181122_151822_add_view_count_column_to_arrangement extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Arrangement::tableName(), 'view_count', 'INT DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Arrangement::tableName(), 'view_count');
    }
}
