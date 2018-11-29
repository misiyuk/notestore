<?php

namespace store\entities;

/**
 * This is the model class for table "{{%sale_offer_order}}".
 *
 * @property int $id
 * @property int $sale_offer_id
 * @property string $email
 * @property int $created_at
 *
 * @property SaleOffer $saleOffer
 */
class SaleOfferOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sale_offer_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_offer_id', 'email', 'created_at'], 'required'],
            [['created_at', 'sale_offer_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_offer_id' => 'Sale Offer ID',
            'email' => 'Email',
            'created_at' => 'Created at',
        ];
    }

    public function getSaleOffer()
    {
        return $this->hasOne(SaleOffer::class, ['id' => 'sale_offer_id']);
    }

    public static function create(string $email, int $saleOfferId): self
    {
        $order = new static();
        $order->sale_offer_id = $saleOfferId;
        $order->email = $email;
        $order->created_at = time();
        return $order;
    }
}
