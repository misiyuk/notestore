<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string $src
 * @property string $alt
 * @property string $title
 * @property int $created_at
 * @property int $created_user
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['src', 'created_at', 'created_user'], 'required'],
            [['created_at', 'created_user'], 'integer'],
            [['src', 'alt', 'title'], 'string', 'max' => 255],
            [['src'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
            'alt' => 'Alt',
            'title' => 'Title',
            'created_at' => 'Created At',
            'created_user' => 'Created User',
        ];
    }
}
