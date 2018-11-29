<?php

namespace store\entities;

/**
 * This is the model class for table "{{%offer_type}}".
 *
 * @property int $id
 * @property string $name
 */
class OfferType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer_type}}';
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

    public function edit($name)
    {
        $this->name = $name;
    }

    public static function create($name)
    {
        $offerType = new static();
        $offerType->name = $name;
        return $offerType;
    }

    /**
     * @param string $orderBy
     * @return self[]
     */
    public static function getAll($orderBy = 'name'): array
    {
        return self::find()->orderBy($orderBy)->all();
    }
}
