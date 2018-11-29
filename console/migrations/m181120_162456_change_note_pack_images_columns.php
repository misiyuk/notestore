<?php

use yii\db\Migration;
use store\entities\NotePack;
use store\entities\Image;

/**
 * Class m181120_162456_change_note_pack_images_columns
 */
class m181120_162456_change_note_pack_images_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-note_pack-preview_image_id}}', NotePack::tableName());
        $this->dropForeignKey('{{%fk-note_pack-detail_image_id}}', NotePack::tableName());
        $this->dropColumn(NotePack::tableName(), 'preview_image_id');
        $this->dropColumn(NotePack::tableName(), 'detail_image_id');
        $this->addColumn(NotePack::tableName(), 'preview_image', 'varchar(255)');
        $this->addColumn(NotePack::tableName(), 'detail_image', 'varchar(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(NotePack::tableName(), 'preview_image');
        $this->dropColumn(NotePack::tableName(), 'detail_image');
        $this->addColumn(NotePack::tableName(), 'preview_image_id', 'integer(11)');
        $this->addColumn(NotePack::tableName(), 'detail_image_id', 'integer(11)');
        $this->addForeignKey('{{%fk-note_pack-preview_image_id}}', NotePack::tableName(), 'preview_image_id', Image::tableName(), 'id');
        $this->addForeignKey('{{%fk-note_pack-detail_image_id}}', NotePack::tableName(), 'detail_image_id', Image::tableName(), 'id');
    }
}
