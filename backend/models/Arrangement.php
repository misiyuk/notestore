<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%arrangement}}".
 *
 * @property int $id
 * @property int $preview_image_id
 * @property int $detail_image_id
 * @property string $slug
 * @property int $song_id
 * @property int $arrangement_type_id
 * @property int $formats_id
 * @property int $created_at
 * @property int $created_user
 * @property int $updated_at
 * @property int $updated_user
 *
 * @property ArrangementType $arrangementType
 * @property Song $song
 * @property ArrangementFilmAssignments[] $arrangementFilmAssignments
 * @property Film[] $films
 * @property NotePackArrangementAssignments[] $notePackArrangementAssignments
 * @property NotePack[] $notePacks
 * @property SongArrangementAssignments[] $songArrangementAssignments
 * @property Song[] $songs
 */
class Arrangement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arrangement}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preview_image_id', 'detail_image_id', 'slug', 'song_id', 'arrangement_type_id', 'formats_id', 'created_at', 'created_user', 'updated_at', 'updated_user'], 'required'],
            [['preview_image_id', 'detail_image_id', 'song_id', 'arrangement_type_id', 'formats_id', 'created_at', 'created_user', 'updated_at', 'updated_user'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['arrangement_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArrangementType::className(), 'targetAttribute' => ['arrangement_type_id' => 'id']],
            [['song_id'], 'exist', 'skipOnError' => true, 'targetClass' => Song::className(), 'targetAttribute' => ['song_id' => 'id']],
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
            'slug' => 'Slug',
            'song_id' => 'Song ID',
            'arrangement_type_id' => 'Arrangement Type ID',
            'formats_id' => 'Formats ID',
            'created_at' => 'Created At',
            'created_user' => 'Created User',
            'updated_at' => 'Updated At',
            'updated_user' => 'Updated User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementType()
    {
        return $this->hasOne(ArrangementType::className(), ['id' => 'arrangement_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementFilmAssignments()
    {
        return $this->hasMany(ArrangementFilmAssignments::className(), ['arrangement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilms()
    {
        return $this->hasMany(Film::className(), ['id' => 'film_id'])->viaTable('{{%arrangement_film_assignments}}', ['arrangement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotePackArrangementAssignments()
    {
        return $this->hasMany(NotePackArrangementAssignments::className(), ['arrangement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotePacks()
    {
        return $this->hasMany(NotePack::className(), ['id' => 'note_pack_id'])->viaTable('{{%note_pack_arrangement_assignments}}', ['arrangement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongArrangementAssignments()
    {
        return $this->hasMany(SongArrangementAssignments::className(), ['arrangement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['id' => 'song_id'])->viaTable('{{%song_arrangement_assignments}}', ['arrangement_id' => 'id']);
    }
}
