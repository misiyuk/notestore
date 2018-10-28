<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%note_pack}}".
 *
 * @property int $id
 * @property int $preview_image_id
 * @property int $detail_image_id
 * @property string $name
 * @property string $slug
 * @property int $artist_id
 * @property string $description
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property Artist $artist
 * @property NotePackArrangementAssignments[] $notePackArrangementAssignments
 * @property Arrangement[] $arrangements
 */
class NotePack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%note_pack}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preview_image_id', 'detail_image_id', 'name', 'slug', 'artist_id', 'description', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['preview_image_id', 'detail_image_id', 'artist_id', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::className(), 'targetAttribute' => ['artist_id' => 'id']],
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
            'artist_id' => 'Artist ID',
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
    public function getArtist()
    {
        return $this->hasOne(Artist::className(), ['id' => 'artist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotePackArrangementAssignments()
    {
        return $this->hasMany(NotePackArrangementAssignments::className(), ['note_pack_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::className(), ['id' => 'arrangement_id'])->viaTable('{{%note_pack_arrangement_assignments}}', ['note_pack_id' => 'id']);
    }
}
