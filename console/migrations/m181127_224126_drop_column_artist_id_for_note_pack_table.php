<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `column_artist_id_for_note_pack`.
 */
class m181127_224126_drop_column_artist_id_for_note_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-note_pack-artist_id}}', '{{%note_pack}}');
        $this->dropColumn('{{%note_pack}}', 'artist_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%note_pack}}', 'artist_id', $this->integer());
        $this->createIndex('{{%idx-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id');
        $this->addForeignKey('{{%fk-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
