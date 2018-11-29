<?php

use yii\db\Migration;

/**
 * Class m181121_111840_create_indexes_for_user
 */
class m181121_111840_create_indexes_for_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-artist-created_user_id}}', '{{%artist}}', 'created_user_id');
        $this->createIndex('{{%idx-artist-updated_user_id}}', '{{%artist}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-artist-created_user_id}}', '{{%artist}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-artist-updated_user_id}}', '{{%artist}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-song-created_user_id}}', '{{%song}}', 'created_user_id');
        $this->createIndex('{{%idx-song-updated_user_id}}', '{{%song}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-song-created_user_id}}', '{{%song}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song-updated_user_id}}', '{{%song}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-arrangement-created_user_id}}', '{{%arrangement}}', 'created_user_id');
        $this->createIndex('{{%idx-arrangement-updated_user_id}}', '{{%arrangement}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-arrangement-created_user_id}}', '{{%arrangement}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-arrangement-updated_user_id}}', '{{%arrangement}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-film-created_user_id}}', '{{%film}}', 'created_user_id');
        $this->createIndex('{{%idx-film-updated_user_id}}', '{{%film}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-film-created_user_id}}', '{{%film}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-film-updated_user_id}}', '{{%film}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-note_pack-created_user_id}}', '{{%note_pack}}', 'created_user_id');
        $this->createIndex('{{%idx-note_pack-updated_user_id}}', '{{%note_pack}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-note_pack-created_user_id}}', '{{%note_pack}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-note_pack-updated_user_id}}', '{{%note_pack}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-sale_offer-created_user_id}}', '{{%sale_offer}}', 'created_user_id');
        $this->createIndex('{{%idx-sale_offer-updated_user_id}}', '{{%sale_offer}}', 'updated_user_id');
        $this->addForeignKey('{{%fk-sale_offer-created_user_id}}', '{{%sale_offer}}', 'created_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-sale_offer-updated_user_id}}', '{{%sale_offer}}', 'updated_user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-artist-created_user_id}}', '{{%artist}}');
        $this->dropForeignKey('{{%fk-artist-updated_user_id}}', '{{%artist}}');
        $this->dropForeignKey('{{%fk-song-created_user_id}}', '{{%song}}');
        $this->dropForeignKey('{{%fk-song-updated_user_id}}', '{{%song}}');
        $this->dropForeignKey('{{%fk-arrangement-created_user_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-arrangement-updated_user_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-film-created_user_id}}', '{{%film}}');
        $this->dropForeignKey('{{%fk-film-updated_user_id}}', '{{%film}}');
        $this->dropForeignKey('{{%fk-note_pack-created_user_id}}', '{{%note_pack}}');
        $this->dropForeignKey('{{%fk-note_pack-updated_user_id}}', '{{%note_pack}}');
        $this->dropForeignKey('{{%fk-sale_offer-created_user_id}}', '{{%sale_offer}}');
        $this->dropForeignKey('{{%fk-sale_offer-updated_user_id}}', '{{%sale_offer}}');
    }
}
