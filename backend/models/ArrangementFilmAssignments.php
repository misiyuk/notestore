<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%arrangement_film_assignments}}".
 *
 * @property int $arrangement_id
 * @property int $film_id
 *
 * @property Arrangement $arrangement
 * @property Film $film
 */
class ArrangementFilmAssignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arrangement_film_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['arrangement_id', 'film_id'], 'required'],
            [['arrangement_id', 'film_id'], 'integer'],
            [['arrangement_id', 'film_id'], 'unique', 'targetAttribute' => ['arrangement_id', 'film_id']],
            [['arrangement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrangement::className(), 'targetAttribute' => ['arrangement_id' => 'id']],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Film::className(), 'targetAttribute' => ['film_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'arrangement_id' => 'Arrangement ID',
            'film_id' => 'Film ID',
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
    public function getFilm()
    {
        return $this->hasOne(Film::className(), ['id' => 'film_id']);
    }
}
