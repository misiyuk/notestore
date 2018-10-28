<?php

use yii\db\Migration;

/**
 * Class m181017_220007_add_test_data
 */
class m181017_220007_add_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%arrangement_type}}', [
                'id' => $i,
                'name' => 'Вокал' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%artist}}', [
                'id' => $i,
                'preview_image_id' => $i,
                'detail_image_id' => $i,
                'name' => 'name' . $i,
                'slug' => 'slug' . $i,
                'description' => 'description' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%song}}', [
                'id' => $i,
                'name' => 'name' . $i,
                'text' => 'text' . $i,
                'video' => 'video' . $i,
                'audio' => 'audio' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%arrangement}}', [
                'id' => $i,
                'preview_image_id' => $i,
                'detail_image_id' => $i,
                'slug' => 'slug' . $i,
                'song_id' => $i,
                'arrangement_type_id' => $i,
                'formats_id' => $i,
                'created_at' => time(),
                'created_user' => 1,
                'updated_at' => time(),
                'updated_user' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%image}}', [
                'id' => $i,
                'src' => 'src' . $i,
                'alt' => 'alt' . $i,
                'title' => 'title' . $i,
                'created_at' => time(),
                'created_user' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%film}}', [
                'id' => $i,
                'name' => 'name' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%arrangement_film_assignments}}', [
                'arrangement_id' => $i,
                'film_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%note_pack}}', [
                'id' => $i,
                'preview_image_id' => $i,
                'detail_image_id' => $i,
                'name' => 'name' . $i,
                'slug' => 'slug' . $i,
                'artist_id' => $i,
                'description' => 'description' . $i,
                'created_at' => time(),
                'created_user_id' => $i,
                'updated_at' => time(),
                'updated_user_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%note_pack_arrangement_assignments}}', [
                'note_pack_id' => $i,
                'arrangement_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%file}}', [
                'id' => $i,
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 3; $i++) {
            $this->insert('{{%offer_type}}', [
                'id' => $i,
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%sale_offer}}', [
                'id' => $i,
                'file_id' => $i,
                'offer_type_id' => $i,
                'offer_id' => $i,
                'price' => 'price' . $i,
                'type' => ($i%2) + 1,
                'created_at' => time(),
                'created_user' => 1,
                'updated_at' => time(),
                'updated_user' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%song_arrangement_assignments}}', [
                'song_id' => $i,
                'arrangement_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%genre}}', [
                'id' => $i,
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%formats}}', [
                'id' => $i,
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%song_artist_assignments}}', [
                'song_id' => $i,
                'artist_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < 10000; $i++) {
            $this->insert('{{%song_genre_assignments}}', [
                'song_id' => $i,
                'genre_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
