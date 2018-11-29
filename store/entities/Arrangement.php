<?php

namespace store\entities;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use store\clientEntities\Cart;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "{{%arrangement}}".
 *
 * @property int $id
 * @property string $preview_image
 * @property string $detail_image
 * @property string $slug
 * @property int $year
 * @property int $song_id
 * @property int $arrangement_type_id
 * @property int $formats_id
 * @property int $offer_type_id
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 * @property int $view_count
 *
 * @property ArrangementType $arrangementType
 * @property Formats $formats
 * @property NotePack[] $notePacks
 * @property Song $song
 * @property User $createdUser
 * @property User $updatedUser
 * @property SaleOffer[] $saleOffers
 * @property OfferEntity $offerEntity
 * @property string $arrangementName
 * @property Genre[] $genres
 * @property SaleOffer $mainSaleOffer
 */
class Arrangement extends ActiveRecord implements Offer
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arrangement}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'offer_type_id', 'arrangement_type_id', 'formats_id', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['arrangement_type_id', 'formats_id', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id', 'view_count'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['year'], 'integer', 'max' => date('Y')],
            [['slug'], 'unique'],
            [['arrangement_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArrangementType::class, 'targetAttribute' => ['arrangement_type_id' => 'id']],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['saleOffers', 'notePacks'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'preview_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/preview_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/preview_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/preview_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/preview_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'arrangement_list' => ['width' => 185, 'height' => 172],
                    'small_list' => ['width' => 60, 'height' => 60],
                    'cart_list' => ['width' => 90, 'height' => 83],
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'detail_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/detail_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/detail_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/detail_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/detail_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'thumb' => ['width' => 185, 'height' => 172],
                ],
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
            'preview_image' => 'Preview Image',
            'detail_image' => 'Detail Image',
            'slug' => 'Slug',
            'arrangement_type_id' => 'Arrangement Type ID',
            'formats_id' => 'Formats ID',
            'offer_type_id' => 'Offer Type ID',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User',
            'view_count' => 'View count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainSaleOffer()
    {
        return $this->hasOne(SaleOffer::class, [
            'offer_type_id' => 'offer_type_id',
            'offer_id' => 'id',
        ])->where(['offer_entity_id' => $this->offerEntity->id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementType()
    {
        return $this->hasOne(ArrangementType::class, ['id' => 'arrangement_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormats()
    {
        return $this->hasOne(Formats::class, ['id' => 'formats_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotePacks()
    {
        return $this->hasMany(NotePack::class, ['id' => 'note_pack_id'])->viaTable('{{%note_pack_arrangement_assignments}}', ['arrangement_id' => 'id']);
    }

    /**
     * @return OfferEntity
     */
    public function getOfferEntity(): ?ActiveRecord
    {
        return OfferEntity::find()->where(['name' => self::class])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleOffers()
    {
        return $this->hasMany(SaleOffer::class, ['offer_id' => 'id'])
            ->where(['offer_entity_id' => $this->offerEntity->id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::class, ['id' => 'song_id']);
    }

    /**
     * @param UploadedFile $previewImage
     * @param UploadedFile $detailImage
     * @param string $slug
     * @param int $year
     * @param int $arrangementTypeId
     * @param int $formatsId
     * @param int $songId
     * @param int $offerTypeId
     * @param int $userId
     * @return Arrangement
     */
    public static function create(UploadedFile $previewImage, UploadedFile $detailImage, $slug, $year, $arrangementTypeId, $formatsId, $songId, $offerTypeId, $userId): self
    {
        $arrangement = new static();
        $arrangement->preview_image = $previewImage;
        $arrangement->detail_image = $detailImage;
        $arrangement->slug = $slug;
        $arrangement->year = $year;
        $arrangement->song_id = $songId;
        $arrangement->arrangement_type_id = $arrangementTypeId;
        $arrangement->formats_id = $formatsId;
        $arrangement->created_at = time();
        $arrangement->created_user_id = $userId;
        $arrangement->updated_at = $arrangement->created_at;
        $arrangement->updated_user_id = $userId;
        $arrangement->offer_type_id = $offerTypeId;
        return $arrangement;
    }

    /**
     * @param UploadedFile|null $previewImage
     * @param UploadedFile|null $detailImage
     * @param string $slug
     * @param int $year
     * @param int $arrangementTypeId
     * @param int $formatsId
     * @param int $songId
     * @param int $offerTypeId
     * @param int $userId
     */
    public function edit(?UploadedFile $previewImage, ?UploadedFile $detailImage, $slug, $year, $arrangementTypeId, $formatsId, $songId, $offerTypeId, $userId): void
    {
        $this->preview_image = $previewImage ?: $this->preview_image;
        $this->detail_image = $detailImage ?: $this->detail_image;
        $this->slug = $slug;
        $this->year = $year;
        $this->song_id = $songId;
        $this->arrangement_type_id = $arrangementTypeId;
        $this->formats_id = $formatsId;
        $this->updated_at = time();
        $this->updated_user_id = $userId;
        $this->offer_type_id = $offerTypeId;
    }

    /**
     * @param UploadedFile|null $file
     * @param int $offerTypeId
     * @param int $price
     * @param int $userId
     */
    public function setSaleOffer(?UploadedFile $file, int $offerTypeId, int $price, int $userId): void
    {
        $saleOffers = $this->saleOffers;
        foreach ($saleOffers as $saleOffer) {
            if ($saleOffer->isForOfferType($offerTypeId)) {
                $saleOffer->edit(
                    $file,
                    $offerTypeId,
                    $price,
                    $userId
                );
                $this->saleOffers = $saleOffers;
                return;
            }
        }
        $saleOffers[] = SaleOffer::create(
            $file,
            $offerTypeId,
            $price,
            $userId,
            $this->offerEntity->id,
            $this->id
        );
        $this->saleOffers = $saleOffers;
    }

    public function getArrangementName(): string
    {
        return implode(' - ', [$this->song->artistsString, $this->song->name, $this->arrangementType->name]);
    }

    public function title(): string
    {
        return $this->arrangementName;
    }

    public function description(): string
    {
        return $this->arrangementType->name;
    }

    public function url(): string
    {
        return Url::to(['arrangement/view', 'id' => $this->id]);
    }

    /**
     * @return string
     */
    public function getOfferPreviewImage(): string
    {
        /** @var ImageUploadBehavior $this */
        return $this->getThumbFileUrl('preview_image', 'cart_list');
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function inCart(): bool
    {
        /** @var Cart $cart */
        $cart = \Yii::$container->get(Cart::class);
        foreach ($this->saleOffers as $saleOffer) {
            if ($cart->itemIsSet($saleOffer)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        return $this->song->genres ?: [];
    }

    public function beforeSave($insert)
    {
        TagDependency::invalidate(\Yii::$app->cache, 'arrangement');
        return parent::beforeSave($insert);
    }

    public function afterDelete()
    {
        TagDependency::invalidate(\Yii::$app->cache, 'arrangement');
        return parent::afterDelete();
    }
}
