<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%film}}".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property ArrangementFilmAssignments[] $arrangementFilmAssignments
 * @property Arrangement[] $arrangements
 */
class Film extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%film}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementFilmAssignments()
    {
        return $this->hasMany(ArrangementFilmAssignments::className(), ['film_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::className(), ['id' => 'arrangement_id'])->viaTable('{{%arrangement_film_assignments}}', ['film_id' => 'id']);
    }
}
