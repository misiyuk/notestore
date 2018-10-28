<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%sale_offer}}".
 *
 * @property int $id
 * @property int $file_id
 * @property int $offer_type_id
 * @property int $offer_id
 * @property int $price
 * @property int $type
 * @property int $created_at
 * @property int $created_user
 * @property int $updated_at
 * @property int $updated_user
 *
 * @property File $file
 */
class SaleOffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sale_offer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'offer_type_id', 'offer_id', 'price', 'created_at', 'created_user', 'updated_at', 'updated_user'], 'required'],
            [['file_id', 'offer_type_id', 'offer_id', 'price', 'type', 'created_at', 'created_user', 'updated_at', 'updated_user'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'offer_type_id' => 'Offer Type ID',
            'offer_id' => 'Offer ID',
            'price' => 'Price',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_user' => 'Created User',
            'updated_at' => 'Updated At',
            'updated_user' => 'Updated User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}
