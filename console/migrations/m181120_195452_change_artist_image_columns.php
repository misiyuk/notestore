<?php

use yii\db\Migration;
use store\entities\Artist;
use store\entities\Image;

/**
 * Class m181120_195452_change_artist_image_columns
 */
class m181120_195452_change_artist_image_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Artist::tableName(), 'preview_image_id');
        $this->dropColumn(Artist::tableName(), 'detail_image_id');
        $this->addColumn(Artist::tableName(), 'preview_image', 'varchar(255)');
        $this->addColumn(Artist::tableName(), 'detail_image', 'varchar(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Artist::tableName(), 'preview_image');
        $this->dropColumn(Artist::tableName(), 'detail_image');
        $this->addColumn(Artist::tableName(), 'preview_image_id', 'integer(11)');
        $this->addColumn(Artist::tableName(), 'detail_image_id', 'integer(11)');
    }
}
