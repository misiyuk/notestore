<?php

use yii\db\Migration;

/**
 * Class m181105_225336_add_test_data_to_song_arrangement_assignments
 */
class m181105_225336_add_test_data_to_song_arrangement_assignments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_225336_add_test_data_to_song_arrangement_assignments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_225336_add_test_data_to_song_arrangement_assignments cannot be reverted.\n";

        return false;
    }
    */
}
