<?php

namespace store\entities;

use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%sale_offer}}".
 *
 * @property int $id
 * @property string $file
 * @property int $offer_type_id
 * @property int $offer_id
 * @property float $price
 * @property int $offer_entity_id
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property User $createdUser
 * @property User $updatedUser
 * @property OfferEntity $offerEntity
 * @property OfferType $offerType
 * @property Offer $offer
 * @property string $priceNotePackView
 * @property string $priceArrangementView
 * @property string $priceArrangementsView
 * @property NotePack $notePack
 * @property int $oldPrice
 * @property int $newPrice
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
            [['file', 'offer_type_id', 'offer_id', 'price', 'created_at', 'offer_entity_id', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['offer_type_id', 'offer_id', 'offer_entity_id', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['price'], 'double'],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file',
                'filePath' => '@filesRoot/[[id]].[[extension]]',
                'fileUrl' => '@files/[[id]].[[extension]]',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'offer_type_id' => 'Offer Type ID',
            'offer_id' => 'Offer ID',
            'price' => 'Price',
            'offer_entity_id' => 'Offer entity id',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_user_id']);
    }

    public function getOfferEntity()
    {
        return $this->hasOne(OfferEntity::class, ['id' => 'offer_entity_id']);
    }

    public function getOffer()
    {
        return $this->hasOne($this->offerEntity->name, ['id' => 'offer_id']);
    }

    public function getOfferType()
    {
        return $this->hasOne(OfferType::class, ['id' => 'offer_type_id']);
    }

    public function isForOfferType(int $offerTypeId): bool
    {
        return $this->offer_type_id == $offerTypeId;
    }

    /**
     * @param UploadedFile|null $file
     * @param int $offerTypeId
     * @param float $price
     * @param int $userId
     */
    public function edit(?UploadedFile $file, int $offerTypeId, float $price, int $userId): void
    {
        $this->file = $file ?: $this->file;
        $this->offer_type_id = $offerTypeId;
        $this->price = $price;
        $this->updated_at = time();
        $this->updated_user_id = $userId;
    }

    /**
     * @param UploadedFile $file
     * @param int $offerTypeId
     * @param float $price
     * @param int $userId
     * @param int $offerEntityId
     * @param int $offerId
     * @return SaleOffer
     */
    public static function create(UploadedFile $file, int $offerTypeId, float $price, int $userId, int $offerEntityId, int $offerId): self
    {
        $saleOffer = new static();
        $saleOffer->file = $file;
        $saleOffer->offer_type_id = $offerTypeId;
        $saleOffer->price = $price;
        $saleOffer->offer_entity_id = $offerEntityId;
        $saleOffer->offer_id = $offerId;
        $saleOffer->created_at = time();
        $saleOffer->created_user_id = $userId;
        $saleOffer->updated_at = $saleOffer->created_at;
        $saleOffer->updated_user_id = $userId;
        return $saleOffer;
    }

    public function isNotePack(): bool
    {
        return $this->offer_entity_id == (new NotePack())->offerEntity->id;
    }

    public function getNewPrice(): float
    {
        return $this->price * (1 - ($this->notePack->discount / 100));
    }

    public function getNotePack(): ?ActiveQuery
    {
        if ($this->isNotePack()) {
            return $this->hasOne(NotePack::class, ['id' => 'offer_id']);
        }
        return null;
    }

    public function getOldPrice(): float
    {
        return $this->price;
    }

    public function getPrice(): float
    {
        return $this->getNewPrice();
    }
}
