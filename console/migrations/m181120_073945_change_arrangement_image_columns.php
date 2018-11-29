<?php

use yii\db\Migration;
use store\entities\Arrangement;
use store\entities\Image;

/**
 * Class m181120_073945_change_arrangement_image_columns
 */
class m181120_073945_change_arrangement_image_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-arrangement-preview_image_id}}', Arrangement::tableName());
        $this->dropForeignKey('{{%fk-arrangement-detail_image_id}}', Arrangement::tableName());
        $this->dropColumn(Arrangement::tableName(), 'preview_image_id');
        $this->dropColumn(Arrangement::tableName(), 'detail_image_id');
        $this->addColumn(Arrangement::tableName(), 'preview_image', 'varchar(255)');
        $this->addColumn(Arrangement::tableName(), 'detail_image', 'varchar(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Arrangement::tableName(), 'preview_image');
        $this->dropColumn(Arrangement::tableName(), 'detail_image');
        $this->addColumn(Arrangement::tableName(), 'preview_image_id', 'integer(11)');
        $this->addColumn(Arrangement::tableName(), 'detail_image_id', 'integer(11)');
        $this->createIndex('{{%idx-arrangement-preview_image_id}}', Arrangement::tableName(), 'preview_image_id');
        $this->createIndex('{{%idx-arrangement-detail_image_id}}', Arrangement::tableName(), 'detail_image_id');
        $this->addForeignKey('{{%fk-arrangement-preview_image_id}}', Arrangement::tableName(), 'preview_image_id', Image::tableName(), 'id');
        $this->addForeignKey('{{%fk-arrangement-detail_image_id}}', Arrangement::tableName(), 'detail_image_id', Image::tableName(), 'id');
    }
}
