<?php

namespace store\entities;

/**
 * This is the model class for table "{{%formats}}".
 *
 * @property int $id
 * @property string $name
 */
class Formats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%formats}}';
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
     * @param $name
     */
    public function edit($name): void
    {
        $this->name = $name;
    }

    /**
     * @param $name
     * @return Formats
     */
    public static function create($name): self
    {
        $formats = new static();
        $formats->name = $name;
        return $formats;
    }
}
