<?php

namespace store\entities;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property int $created_at
 *
 * @property SaleOffer $saleOffer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'phone', 'email', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['fio', 'phone', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'FIO',
            'phone' => 'Phone',
            'email' => 'Email',
            'created_at' => 'Created at',
        ];
    }

    public function edit($fio, $phone, $email): void
    {
        $this->fio = $fio;
        $this->phone = $phone;
        $this->email = $email;
    }

    public static function create($fio, $phone, $email): self
    {
        $order = new static();
        $order->fio = $fio;
        $order->phone = $phone;
        $order->email = $email;
        $order->created_at = time();
        return $order;
    }
}
