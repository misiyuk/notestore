<?php

use yii\db\Migration;

/**
 * Class m181016_220817_main_tables
 */
class m181016_220817_main_tables extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%arrangement_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%artist}}', [
            'id' => $this->primaryKey(),
            'preview_image_id' => $this->integer()->notNull(),
            'detail_image_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-artist-preview_image_id}}', '{{%artist}}', 'preview_image_id');
        $this->createIndex('{{%idx-artist-detail_image_id}}', '{{%artist}}', 'detail_image_id');
        $this->createIndex('{{%idx-artist-slug}}', '{{%artist}}', 'slug', true);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'video' => $this->string()->notNull(),
            'audio' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%arrangement}}', [
            'id' => $this->primaryKey(),
            'preview_image_id' => $this->integer()->notNull(),
            'detail_image_id' => $this->integer()->notNull(),
            'slug' => $this->string()->notNull(),
            'song_id' => $this->integer()->notNull(),
            'arrangement_type_id' => $this->integer()->notNull(),
            'formats_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_user' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_user' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-arrangement-preview_image_id}}', '{{%arrangement}}', 'preview_image_id');
        $this->createIndex('{{%idx-arrangement-detail_image_id}}', '{{%arrangement}}', 'detail_image_id');
        $this->createIndex('{{%idx-arrangement-song_id}}', '{{%arrangement}}', 'song_id');
        $this->createIndex('{{%idx-arrangement-arrangement_type_id}}', '{{%arrangement}}', 'arrangement_type_id');
        $this->createIndex('{{%idx-arrangement-slug}}', '{{%arrangement}}', 'slug', true);

        $this->addForeignKey('{{%fk-arrangement-song_id}}', '{{%arrangement}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-arrangement-arrangement_type_id}}', '{{%arrangement}}', 'arrangement_type_id', '{{%arrangement_type}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'src' => $this->string()->notNull(),
            'alt' => $this->string(),
            'title' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-image-src}}', '{{%image}}', 'src', true);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%film}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-film-name}}', '{{%film}}', 'name', true);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%arrangement_film_assignments}}', [
            'arrangement_id' => $this->integer()->notNull(),
            'film_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-arrangement_film_assignments}}', '{{%arrangement_film_assignments}}', ['arrangement_id', 'film_id']);

        $this->createIndex('{{%idx-arrangement_film_assignments-arrangement_id}}', '{{%arrangement_film_assignments}}', 'arrangement_id');
        $this->createIndex('{{%idx-arrangement_film_assignments-film_id}}', '{{%arrangement_film_assignments}}', 'film_id');

        $this->addForeignKey('{{%fk-arrangement_film_assignments-arrangement_id}}', '{{%arrangement_film_assignments}}', 'arrangement_id', '{{%arrangement}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-arrangement_film_assignments-film_id}}', '{{%arrangement_film_assignments}}', 'film_id', '{{%film}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%note_pack}}', [
            'id' => $this->primaryKey(),
            'preview_image_id' => $this->integer()->notNull(),
            'detail_image_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'artist_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-note_pack-preview_image_id}}', '{{%note_pack}}', 'preview_image_id');
        $this->createIndex('{{%idx-note_pack-detail_image_id}}', '{{%note_pack}}', 'detail_image_id');
        $this->createIndex('{{%idx-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id');
        $this->createIndex('{{%idx-note_pack-slug}}', '{{%note_pack}}', 'slug', true);

        $this->addForeignKey('{{%fk-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%note_pack_arrangement_assignments}}', [
            'note_pack_id' => $this->integer()->notNull(),
            'arrangement_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-note_pack_arrangement_assignments}}', '{{%note_pack_arrangement_assignments}}', ['note_pack_id', 'arrangement_id']);

        $this->createIndex('{{%idx-note_pack_arrangement_assignments-note_pack_id}}', '{{%note_pack_arrangement_assignments}}', 'note_pack_id');
        $this->createIndex('{{%idx-note_pack_arrangement_assignments-arrangement_id}}', '{{%note_pack_arrangement_assignments}}', 'arrangement_id');

        $this->addForeignKey('{{%fk-note_pack_arrangement_assignments-note_pack_id}}', '{{%note_pack_arrangement_assignments}}', 'note_pack_id', '{{%note_pack}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-note_pack_arrangement_assignments-arrangement_id}}', '{{%note_pack_arrangement_assignments}}', 'arrangement_id', '{{%arrangement}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%offer_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%sale_offer}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer()->notNull(),
            'offer_type_id' => $this->integer()->notNull(),
            'offer_id' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id');
        $this->createIndex('{{%idx-sale_offer-offer_type_id}}', '{{%sale_offer}}', 'offer_type_id');
        $this->createIndex('{{%idx-sale_offer-offer_id}}', '{{%sale_offer}}', 'offer_id');

        $this->addForeignKey('{{%fk-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id', '{{%file}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song_arrangement_assignments}}', [
            'song_id' => $this->integer()->notNull(),
            'arrangement_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-song_arrangement_assignments}}', '{{%song_arrangement_assignments}}', ['song_id', 'arrangement_id']);

        $this->createIndex('{{%idx-song_arrangement_assignments-song_id}}', '{{%song_arrangement_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_arrangement_assignments-arrangement_id}}', '{{%song_arrangement_assignments}}', 'arrangement_id');

        $this->addForeignKey('{{%fk-song_arrangement_assignments-song_id}}', '{{%song_arrangement_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_arrangement_assignments-arrangement_id}}', '{{%song_arrangement_assignments}}', 'arrangement_id', '{{%arrangement}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%formats}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song_artist_assignments}}', [
            'song_id' => $this->integer()->notNull(),
            'artist_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-song_artist_assignments}}', '{{%song_artist_assignments}}', ['song_id', 'artist_id']);

        $this->createIndex('{{%idx-song_artist_assignments-song_id}}', '{{%song_artist_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_artist_assignments-artist_id}}', '{{%song_artist_assignments}}', 'artist_id');

        $this->addForeignKey('{{%fk-song_artist_assignments-song_id}}', '{{%song_artist_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_artist_assignments-artist_id}}', '{{%song_artist_assignments}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song_genre_assignments}}', [
            'song_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-song_genre_assignments}}', '{{%song_genre_assignments}}', ['song_id', 'genre_id']);

        $this->createIndex('{{%idx-song_genre_assignments-song_id}}', '{{%song_genre_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_genre_assignments-genre_id}}', '{{%song_genre_assignments}}', 'genre_id');

        $this->addForeignKey('{{%fk-song_genre_assignments-song_id}}', '{{%song_genre_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_genre_assignments-genre_id}}', '{{%song_genre_assignments}}', 'genre_id', '{{%genre}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%arrangement}}');
        $this->dropTable('{{%image}}');
        $this->dropTable('{{%film}}');
        $this->dropTable('{{%arrangement_film_assignments}}');
        $this->dropTable('{{%note_pack}}');
        $this->dropTable('{{%artist}}');
        $this->dropTable('{{%note_pack_arrangement_assignments}}');
        $this->dropTable('{{%arrangement_type}}');
        $this->dropTable('{{%offer_type}}');
        $this->dropTable('{{%sale_offer}}');
        $this->dropTable('{{%file}}');
        $this->dropTable('{{%song_arrangement_assignments}}');
        $this->dropTable('{{%genre}}');
        $this->dropTable('{{%formats}}');
        $this->dropTable('{{%song_artist_assignments}}');
        $this->dropTable('{{%song_genre_assignments}}');
        $this->dropTable('{{%song}}');
    }
}
