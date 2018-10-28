<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%song_artist_assignments}}".
 *
 * @property int $song_id
 * @property int $artist_id
 *
 * @property Artist $artist
 * @property Song $song
 */
class SongArtistAssignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%song_artist_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['song_id', 'artist_id'], 'required'],
            [['song_id', 'artist_id'], 'integer'],
            [['song_id', 'artist_id'], 'unique', 'targetAttribute' => ['song_id', 'artist_id']],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::className(), 'targetAttribute' => ['artist_id' => 'id']],
            [['song_id'], 'exist', 'skipOnError' => true, 'targetClass' => Song::className(), 'targetAttribute' => ['song_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'song_id' => 'Song ID',
            'artist_id' => 'Artist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::className(), ['id' => 'artist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }
}
