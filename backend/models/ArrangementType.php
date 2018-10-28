<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%arrangement_type}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property Arrangement[] $arrangements
 */
class ArrangementType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arrangement_type}}';
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
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::className(), ['arrangement_type_id' => 'id']);
    }
}
