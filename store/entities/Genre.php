<?php

namespace store\entities;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $name
 *
 * @property Song[] $songs
 * @property Artist[] $artists
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%genre}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::class, ['id' => 'song_id'])->viaTable('song_genre_assignments', ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtists()
    {
        return $this->hasMany(Artist::class, ['id' => 'artist_id'])->viaTable('artist_genre_assignments', ['genre_id' => 'id']);
    }

    public static function create(string $name): self
    {
        $genre = new static();
        $genre->name = $name;
        return $genre;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }
}
