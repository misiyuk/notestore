<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%song}}".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $video
 * @property string $audio
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property Arrangement[] $arrangements
 * @property SongArrangementAssignments[] $songArrangementAssignments
 * @property Arrangement[] $arrangements0
 * @property SongArtistAssignments[] $songArtistAssignments
 * @property Artist[] $artists
 * @property SongGenreAssignments[] $songGenreAssignments
 * @property Genre[] $genres
 */
class Song extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%song}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text', 'video', 'audio', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['text'], 'string'],
            [['created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['name', 'video', 'audio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'video' => 'Video',
            'audio' => 'Audio',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::className(), ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongArrangementAssignments()
    {
        return $this->hasMany(SongArrangementAssignments::className(), ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements0()
    {
        return $this->hasMany(Arrangement::className(), ['id' => 'arrangement_id'])->viaTable('{{%song_arrangement_assignments}}', ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongArtistAssignments()
    {
        return $this->hasMany(SongArtistAssignments::className(), ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtists()
    {
        return $this->hasMany(Artist::className(), ['id' => 'artist_id'])->viaTable('{{%song_artist_assignments}}', ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongGenreAssignments()
    {
        return $this->hasMany(SongGenreAssignments::className(), ['song_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])->viaTable('{{%song_genre_assignments}}', ['song_id' => 'id']);
    }
}
