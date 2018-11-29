<?php

use yii\db\Migration;

/**
 * Class m181016_220817_main_tables
 */
class m181016_220817_main_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
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
            'year' => $this->integer()->notNull(),
            'song_id' => $this->integer()->notNull(),
            'arrangement_type_id' => $this->integer()->notNull(),
            'formats_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_user_id' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_user_id' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'src' => $this->string()->notNull(),
            'alt' => $this->string(),
            'title' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%film}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song_film_assignments}}', [
            'song_id' => $this->integer()->notNull(),
            'film_id' => $this->integer()->notNull(),
        ], $tableOptions);
        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%note_pack}}', [
            'id' => $this->primaryKey(),
            'preview_image_id' => $this->integer()->notNull(),
            'detail_image_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'discount' => $this->integer()->notNull(),
            'artist_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%note_pack_arrangement_assignments}}', [
            'note_pack_id' => $this->integer()->notNull(),
            'arrangement_id' => $this->integer()->notNull(),
        ], $tableOptions);
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

        $this->createTable('{{%offer_entity}}', [
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
            'offer_entity_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_user_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_user_id' => $this->integer()->notNull(),
        ], $tableOptions);
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
        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%song_genre_assignments}}', [
            'song_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
        ], $tableOptions);
        //--------------------------------------------------------------------------------------------

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-song_genre_assignments}}', '{{%song_genre_assignments}}', ['song_id', 'genre_id']);

        $this->createIndex('{{%idx-song_genre_assignments-song_id}}', '{{%song_genre_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_genre_assignments-genre_id}}', '{{%song_genre_assignments}}', 'genre_id');

        $this->addForeignKey('{{%fk-song_genre_assignments-song_id}}', '{{%song_genre_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_genre_assignments-genre_id}}', '{{%song_genre_assignments}}', 'genre_id', '{{%genre}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-artist-preview_image_id}}', '{{%artist}}', 'preview_image_id');
        $this->createIndex('{{%idx-artist-detail_image_id}}', '{{%artist}}', 'detail_image_id');
        $this->addForeignKey('{{%fk-artist-preview_image_id}}', '{{%artist}}', 'preview_image_id', '{{%image}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-artist-detail_image_id}}', '{{%artist}}', 'detail_image_id', '{{%image}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-artist-slug}}', '{{%artist}}', 'slug', true);

        $this->createIndex('{{%idx-arrangement-preview_image_id}}', '{{%arrangement}}', 'preview_image_id');
        $this->createIndex('{{%idx-arrangement-detail_image_id}}', '{{%arrangement}}', 'detail_image_id');
        $this->createIndex('{{%idx-arrangement-arrangement_type_id}}', '{{%arrangement}}', 'arrangement_type_id');
        $this->createIndex('{{%idx-arrangement-slug}}', '{{%arrangement}}', 'slug', true);

        $this->addForeignKey('{{%fk-arrangement-preview_image_id}}', '{{%arrangement}}', 'preview_image_id', '{{%image}}', 'id');
        $this->addForeignKey('{{%fk-arrangement-detail_image_id}}', '{{%arrangement}}', 'detail_image_id', '{{%image}}', 'id');
        $this->addForeignKey('{{%fk-arrangement-arrangement_type_id}}', '{{%arrangement}}', 'arrangement_type_id', '{{%arrangement_type}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-image-src}}', '{{%image}}', 'src', true);
        $this->createIndex('{{%idx-film-name}}', '{{%film}}', 'name', true);
        $this->addPrimaryKey('{{%pk-song_film_assignments}}', '{{%song_film_assignments}}', ['song_id', 'film_id']);

        $this->createIndex('{{%idx-song_film_assignments-song_id}}', '{{%song_film_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_film_assignments-film_id}}', '{{%song_film_assignments}}', 'film_id');

        $this->addForeignKey('{{%fk-song_film_assignments-song_id}}', '{{%song_film_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_film_assignments-film_id}}', '{{%song_film_assignments}}', 'film_id', '{{%film}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-note_pack-preview_image_id}}', '{{%note_pack}}', 'preview_image_id');
        $this->createIndex('{{%idx-note_pack-detail_image_id}}', '{{%note_pack}}', 'detail_image_id');
        $this->createIndex('{{%idx-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id');
        $this->createIndex('{{%idx-note_pack-slug}}', '{{%note_pack}}', 'slug', true);
        $this->addForeignKey('{{%fk-note_pack-preview_image_id}}', '{{%note_pack}}', 'preview_image_id', '{{%image}}', 'id');
        $this->addForeignKey('{{%fk-note_pack-detail_image_id}}', '{{%note_pack}}', 'detail_image_id', '{{%image}}', 'id');

        $this->addForeignKey('{{%fk-note_pack-artist_id}}', '{{%note_pack}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');

        $this->addPrimaryKey('{{%pk-note_pack_arrangement_assignments}}', '{{%note_pack_arrangement_assignments}}', ['note_pack_id', 'arrangement_id']);

        $this->createIndex('{{%idx-note_pack_arrangement_assignments-note_pack_id}}', '{{%note_pack_arrangement_assignments}}', 'note_pack_id');
        $this->createIndex('{{%idx-note_pack_arrangement_assignments-arrangement_id}}', '{{%note_pack_arrangement_assignments}}', 'arrangement_id');

        $this->addForeignKey('{{%fk-note_pack_arrangement_assignments-note_pack_id}}', '{{%note_pack_arrangement_assignments}}', 'note_pack_id', '{{%note_pack}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-note_pack_arrangement_assignments-arrangement_id}}', '{{%note_pack_arrangement_assignments}}', 'arrangement_id', '{{%arrangement}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id');
        $this->createIndex('{{%idx-sale_offer-offer_type_id}}', '{{%sale_offer}}', 'offer_type_id');
        $this->createIndex('{{%idx-sale_offer-offer_id}}', '{{%sale_offer}}', 'offer_id');

        $this->addForeignKey('{{%fk-sale_offer-file_id}}', '{{%sale_offer}}', 'file_id', '{{%file}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-sale_offer-offer_entity_id}}', '{{%sale_offer}}', 'offer_entity_id', '{{%offer_entity}}', 'id');
        $this->addForeignKey('{{%fk-sale_offer-offer_type_id}}', '{{%sale_offer}}', 'offer_type_id', '{{%offer_type}}', 'id');

        $this->createIndex('{{%idx-arrangement-song_id}}', '{{%arrangement}}', 'song_id');
        $this->addForeignKey('{{%fk-arrangement-song_id}}', '{{%arrangement}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');

        $this->addPrimaryKey('{{%pk-song_artist_assignments}}', '{{%song_artist_assignments}}', ['song_id', 'artist_id']);

        $this->createIndex('{{%idx-song_artist_assignments-song_id}}', '{{%song_artist_assignments}}', 'song_id');
        $this->createIndex('{{%idx-song_artist_assignments-artist_id}}', '{{%song_artist_assignments}}', 'artist_id');

        $this->addForeignKey('{{%fk-song_artist_assignments-song_id}}', '{{%song_artist_assignments}}', 'song_id', '{{%song}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-song_artist_assignments-artist_id}}', '{{%song_artist_assignments}}', 'artist_id', '{{%artist}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-sale_offer-offer_entity_id}}', '{{%sale_offer}}');
        $this->dropForeignKey('{{%fk-song_genre_assignments-song_id}}', '{{%song_genre_assignments}}');
        $this->dropForeignKey('{{%fk-song_genre_assignments-genre_id}}', '{{%song_genre_assignments}}');
        $this->dropForeignKey('{{%fk-arrangement-arrangement_type_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-song_film_assignments-song_id}}', '{{%song_film_assignments}}');
        $this->dropForeignKey('{{%fk-song_film_assignments-film_id}}', '{{%song_film_assignments}}');
        $this->dropForeignKey('{{%fk-note_pack-artist_id}}', '{{%note_pack}}');
        $this->dropForeignKey('{{%fk-note_pack_arrangement_assignments-note_pack_id}}', '{{%note_pack_arrangement_assignments}}');
        $this->dropForeignKey('{{%fk-note_pack_arrangement_assignments-arrangement_id}}', '{{%note_pack_arrangement_assignments}}');
        $this->dropForeignKey('{{%fk-sale_offer-file_id}}', '{{%sale_offer}}');
        $this->dropForeignKey('{{%fk-song_artist_assignments-song_id}}', '{{%song_artist_assignments}}');
        $this->dropForeignKey('{{%fk-song_artist_assignments-artist_id}}', '{{%song_artist_assignments}}');
        $this->dropForeignKey('{{%fk-arrangement-song_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-note_pack-preview_image_id}}', '{{%note_pack}}');
        $this->dropForeignKey('{{%fk-note_pack-detail_image_id}}', '{{%note_pack}}');
        $this->dropForeignKey('{{%fk-arrangement-preview_image_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-arrangement-detail_image_id}}', '{{%arrangement}}');
        $this->dropForeignKey('{{%fk-artist-preview_image_id}}', '{{%artist}}');
        $this->dropForeignKey('{{%fk-artist-detail_image_id}}', '{{%artist}}');
        $this->dropForeignKey('{{%fk-sale_offer-offer_type_id}}', '{{%sale_offer}}');

        $this->dropTable('{{%arrangement}}');
        $this->dropTable('{{%image}}');
        $this->dropTable('{{%film}}');
        $this->dropTable('{{%song_film_assignments}}');
        $this->dropTable('{{%note_pack}}');
        $this->dropTable('{{%artist}}');
        $this->dropTable('{{%note_pack_arrangement_assignments}}');
        $this->dropTable('{{%arrangement_type}}');
        $this->dropTable('{{%offer_type}}');
        $this->dropTable('{{%offer_entity}}');
        $this->dropTable('{{%sale_offer}}');
        $this->dropTable('{{%file}}');
        $this->dropTable('{{%genre}}');
        $this->dropTable('{{%formats}}');
        $this->dropTable('{{%song_artist_assignments}}');
        $this->dropTable('{{%song_genre_assignments}}');
        $this->dropTable('{{%song}}');
        $this->dropTable('{{%order}}');
    }
}
