<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%song_genre_assignments}}".
 *
 * @property int $song_id
 * @property int $genre_id
 *
 * @property Genre $genre
 * @property Song $song
 */
class SongGenreAssignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%song_genre_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['song_id', 'genre_id'], 'required'],
            [['song_id', 'genre_id'], 'integer'],
            [['song_id', 'genre_id'], 'unique', 'targetAttribute' => ['song_id', 'genre_id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_id' => 'id']],
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
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }
}
