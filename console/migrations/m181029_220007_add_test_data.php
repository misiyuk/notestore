<?php

use yii\db\Migration;

/**
 * Class m181017_220007_add_test_data
 */
class m181029_220007_add_test_data extends Migration
{
    public const COUNT = 10000;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return 1;
        $count = self::COUNT;
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%arrangement_type}}', [
                'name' => 'Вокал' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%image}}', [
                'src' => 'src' . $i,
                'alt' => 'alt' . $i,
                'title' => 'title' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%artist}}', [
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
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%song}}', [
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
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%arrangement}}', [
                'preview_image_id' => $i,
                'detail_image_id' => $i,
                'slug' => 'slug' . $i,
                'song_id' => $i,
                'arrangement_type_id' => $i,
                'formats_id' => $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%film}}', [
                'name' => 'name' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%song_film_assignments}}', [
                'song_id' => $i,
                'film_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%note_pack}}', [
                'preview_image_id' => $i,
                'detail_image_id' => $i,
                'name' => 'name' . $i,
                'slug' => 'slug' . $i,
                'discount' => $i,
                'artist_id' => $i,
                'description' => 'description' . $i,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%note_pack_arrangement_assignments}}', [
                'note_pack_id' => $i,
                'arrangement_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%file}}', [
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------

        $this->insert('{{%offer_entity}}', [
            'name' => \store\entities\Arrangement::class,
        ]);
        $this->insert('{{%offer_entity}}', [
            'name' => \store\entities\NotePack::class,
        ]);
        //--------------------------------------------------------------------------------------------
        $this->insert('{{%offer_type}}', [
            'name' => '.pdf',
        ]);
        $this->insert('{{%offer_type}}', [
            'name' => '.pdf, .midi',
        ]);
        $this->insert('{{%offer_type}}', [
            'name' => '.pdf, .midi, .finale(ред)',
        ]);
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%sale_offer}}', [
                'file_id' => $i,
                'offer_type_id' => ($i%3) + 1,
                'offer_id' => $i,
                'price' => 'price' . $i,
                'offer_entity_id' => ($i%2) + 1,
                'created_at' => time(),
                'created_user_id' => 1,
                'updated_at' => time(),
                'updated_user_id' => 1,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%genre}}', [
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%formats}}', [
                'name' => 'name' . $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%song_artist_assignments}}', [
                'song_id' => $i,
                'artist_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%song_genre_assignments}}', [
                'song_id' => $i,
                'genre_id' => $i,
            ]);
        }
        //--------------------------------------------------------------------------------------------
        for ($i = 1; $i < $count; $i++) {
            $this->insert('{{%order}}', [
                'fio' => 'fio' . $i,
                'phone' => 'phone' . $i,
                'email' => 'email' . $i,
                'created_at' => time(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return 1;
        $this->delete('{{%order}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%song_genre_assignments}}', ['<', 'song_id', self::COUNT]);
        $this->delete('{{%song_artist_assignments}}', ['<', 'song_id', self::COUNT]);
        $this->delete('{{%formats}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%genre}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%sale_offer}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%file}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%note_pack_arrangement_assignments}}', ['<', 'note_pack_id', self::COUNT]);
        $this->delete('{{%note_pack}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%song_film_assignments}}', ['<', 'song_id', self::COUNT]);
        $this->delete('{{%film}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%arrangement}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%song}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%artist}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%image}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%arrangement_type}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%offer_type}}', ['<', 'id', self::COUNT]);
        $this->delete('{{%offer_entity}}', ['<', 'id', self::COUNT]);
    }
}
