<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%artist}}".
 *
 * @property int $id
 * @property int $preview_image_id
 * @property int $detail_image_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property NotePack[] $notePacks
 * @property SongArtistAssignments[] $songArtistAssignments
 * @property Song[] $songs
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%artist}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preview_image_id', 'detail_image_id', 'name', 'slug', 'description', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['preview_image_id', 'detail_image_id', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preview_image_id' => 'Preview Image ID',
            'detail_image_id' => 'Detail Image ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotePacks()
    {
        return $this->hasMany(NotePack::className(), ['artist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongArtistAssignments()
    {
        return $this->hasMany(SongArtistAssignments::className(), ['artist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['id' => 'song_id'])->viaTable('{{%song_artist_assignments}}', ['artist_id' => 'id']);
    }
}
