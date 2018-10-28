<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%note_pack_arrangement_assignments}}".
 *
 * @property int $note_pack_id
 * @property int $arrangement_id
 *
 * @property Arrangement $arrangement
 * @property NotePack $notePack
 */
class NotePackArrangementAssignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%note_pack_arrangement_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note_pack_id', 'arrangement_id'], 'required'],
            [['note_pack_id', 'arrangement_id'], 'integer'],
            [['note_pack_id', 'arrangement_id'], 'unique', 'targetAttribute' => ['note_pack_id', 'arrangement_id']],
            [['arrangement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrangement::className(), 'targetAttribute' => ['arrangement_id' => 'id']],
            [['note_pack_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotePack::className(), 'targetAttribute' => ['note_pack_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'note_pack_id' => 'Note Pack ID',
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
    public function getNotePack()
    {
        return $this->hasOne(NotePack::className(), ['id' => 'note_pack_id']);
    }
}
