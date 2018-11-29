<?php

namespace store\entities;

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
            'name' => 'Тип арранжировки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::className(), ['arrangement_type_id' => 'id']);
    }

    /**
     * @param $name
     */
    public function edit($name)
    {
        $this->name = $name;
    }

    /**
     * @param $name
     * @return ArrangementType
     */
    public static function create($name)
    {
        $arrangementType = new static();
        $arrangementType->name = $name;
        return $arrangementType;
    }
}
