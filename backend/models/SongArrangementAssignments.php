<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%song_arrangement_assignments}}".
 *
 * @property int $song_id
 * @property int $arrangement_id
 *
 * @property Arrangement $arrangement
 * @property Song $song
 */
class SongArrangementAssignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%song_arrangement_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['song_id', 'arrangement_id'], 'required'],
            [['song_id', 'arrangement_id'], 'integer'],
            [['song_id', 'arrangement_id'], 'unique', 'targetAttribute' => ['song_id', 'arrangement_id']],
            [['arrangement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrangement::className(), 'targetAttribute' => ['arrangement_id' => 'id']],
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
            'arrangement_id' => 'Arrangement ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangement()
    {
        return $this->hasOne(Arrangement::className(), ['id' => 'arrangement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }
}
