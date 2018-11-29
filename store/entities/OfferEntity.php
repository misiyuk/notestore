<?php

namespace store\entities;

/**
 * This is the model class for table "{{%offer_entity}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property SaleOffer[] $saleOffers
 */
class OfferEntity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer_entity}}';
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
    public function getSaleOffers()
    {
        return $this->hasMany(SaleOffer::className(), ['offer_entity_id' => 'id']);
    }

    /**
     * @param string $name
     * @return OfferEntity
     */
    public static function create(string $name): self
    {
        $offerEntity = new static();
        $offerEntity->name = $name;
        return $offerEntity;
    }

    /**
     * @param string $name
     */
    public function edit(string $name): void
    {
        $this->name = $name;
    }
}
