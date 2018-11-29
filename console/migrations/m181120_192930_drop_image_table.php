<?php

use yii\db\Migration;
use store\entities\Artist;

/**
 * Handles the dropping of table `image`.
 */
class m181120_192930_drop_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-artist-preview_image_id}}', Artist::tableName());
        $this->dropForeignKey('{{%fk-artist-detail_image_id}}', Artist::tableName());
        $this->dropTable('{{%image}}');
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

        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'src' => $this->string()->notNull(),
            'alt' => $this->string(),
            'title' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-artist-preview_image_id}}', Artist::tableName(), 'preview_image_id');
        $this->createIndex('{{%idx-artist-detail_image_id}}', Artist::tableName(), 'detail_image_id');
        $this->addForeignKey('{{%fk-artist-preview_image_id}}', Artist::tableName(), 'preview_image_id', '{{%image}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-artist-detail_image_id}}', Artist::tableName(), 'detail_image_id', '{{%image}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
