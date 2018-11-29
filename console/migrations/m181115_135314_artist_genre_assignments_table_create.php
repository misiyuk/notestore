<?php

use yii\db\Migration;

/**
 * Class m181115_135314_artist_genre_assignments_table_create
 */
class m181115_135314_artist_genre_assignments_table_create extends Migration
{
    public function up()
    {
        $this->createTable('{{%artist_genre_assignments}}', [
            'artist_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-artist_genre_assignments}}', '{{%artist_genre_assignments}}', ['artist_id', 'genre_id']);

        $this->createIndex('{{%idx-artist_genre_assignments-artist_id}}', '{{%artist_genre_assignments}}', 'artist_id');
        $this->createIndex('{{%idx-artist_genre_assignments-genre_id}}', '{{%artist_genre_assignments}}', 'genre_id');

        $this->addForeignKey('{{%fk-artist_genre_assignments-artist_id}}', '{{%artist_genre_assignments}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-artist_genre_assignments-genre_id}}', '{{%artist_genre_assignments}}', 'genre_id', '{{%genre}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-artist_genre_assignments-artist_id}}', '{{%artist_genre_assignments}}');
        $this->dropForeignKey('{{%fk-artist_genre_assignments-genre_id}}', '{{%artist_genre_assignments}}');
        $this->dropTable('{{%artist_genre_assignments}}');
    }
}
