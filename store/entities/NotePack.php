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
 * This is the model class for table "{{%note_pack}}".
 *
 * @property int $id
 * @property string $preview_image
 * @property string $detail_image
 * @property string $name
 * @property string $slug
 * @property int $discount
 * @property int $offer_type_id
 * @property string $description
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 * @property int $view_count
 *
 * @property Arrangement[] $arrangements
 * @property User $createdUser
 * @property User $updatedUser
 * @property SaleOffer[] $saleOffers
 * @property NotePackArrangementAssignments[] $arrangementAssignments
 * @property OfferEntity $offerEntity
 * @property Genre[] $genres
 * @property NotePack[] $likeNotePacks
 * @property SaleOffer $mainSaleOffer
 */
class NotePack extends ActiveRecord implements Offer
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%note_pack}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preview_image', 'detail_image', 'name', 'slug', 'discount', 'description', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['discount'], 'integer', 'max' => 100],
            [['slug'], 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['saleOffers', 'arrangementAssignments'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'preview_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/note_pack/preview_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/note_pack/preview_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/note_pack/preview_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/note_pack/preview_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'thumb' => ['width' => 185, 'height' => 172],
                    'cart' => ['width' => 90, 'height' => 83],
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'detail_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/note_pack/detail_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/note_pack/detail_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/note_pack/detail_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/note_pack/detail_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'thumb' => ['width' => 185, 'height' => 172],
                    'detail' => ['width' => 323, 'height' => 439],
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
            'preview_image' => 'Preview Image ID',
            'detail_image' => 'Detail Image ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'discount' => 'Discount',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::class, ['id' => 'arrangement_id'])->viaTable('{{%note_pack_arrangement_assignments}}', ['note_pack_id' => 'id']);
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        $songIds = array_unique(array_map(function (Arrangement $arrangement) {
            return $arrangement->song_id;
        }, $this->arrangements));

        return Genre::find()
            ->alias('genre')
            ->leftJoin(SongGenreAssignments::tableName() . ' as song_assign', 'song_assign.genre_id=genre.id')
            ->where(['song_id' => $songIds])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainSaleOffer()
    {
        return $this->hasOne(SaleOffer::class, [
            'offer_id' => 'id',
            'offer_type_id' => 'offer_type_id',
        ])->where(['offer_entity_id' => $this->offerEntity->id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleOffers()
    {
        return $this->hasMany(SaleOffer::class, ['offer_id' => 'id'])
            ->where(['offer_entity_id' => $this->offerEntity->id])
            ->orderBy('id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementAssignments()
    {
        return $this->hasMany(NotePackArrangementAssignments::class, ['note_pack_id' => 'id']);
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
     * @param string $name
     * @param UploadedFile $previewImage
     * @param UploadedFile $detailImage
     * @param string $slug
     * @param int $discount
     * @param string $description
     * @param int $offerTypeId
     * @param int $userId
     * @return NotePack
     */
    public static function create($name, UploadedFile $previewImage, UploadedFile $detailImage, $slug, $discount, $description, $offerTypeId, $userId): self
    {
        $notePack = new static();
        $notePack->name = $name;
        $notePack->preview_image = $previewImage ?: $notePack->preview_image;
        $notePack->detail_image = $detailImage ?: $notePack->detail_image;
        $notePack->slug = $slug;
        $notePack->discount = $discount;
        $notePack->description = $description;
        $notePack->created_at = time();
        $notePack->created_user_id = $userId;
        $notePack->updated_at = $notePack->created_at;
        $notePack->updated_user_id = $userId;
        $notePack->offer_type_id = $offerTypeId;
        return $notePack;
    }

    /**
     * @param string $name
     * @param UploadedFile|null $previewImage
     * @param UploadedFile|null $detailImage
     * @param string $slug
     * @param int $discount
     * @param string $description
     * @param int $offerTypeId
     * @param int $userId
     */
    public function edit($name, ?UploadedFile $previewImage, ?UploadedFile $detailImage, $slug, $discount, $description, $offerTypeId, $userId): void
    {
        $this->name = $name;
        $this->preview_image = $previewImage ?: $this->preview_image;
        $this->detail_image = $detailImage ?: $this->detail_image;
        $this->slug = $slug;
        $this->discount = $discount;
        $this->description = $description;
        $this->updated_at = time();
        $this->updated_user_id = $userId;
        $this->offer_type_id = $offerTypeId;
    }

    /**
     * @param UploadedFile|null $file
     * @param int $offerTypeId
     * @param float $price
     * @param int $userId
     */
    public function setSaleOffer(?UploadedFile $file, int $offerTypeId, float $price, int $userId): void
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

    public function revokeArrangements(): void
    {
        $this->arrangementAssignments = [];
    }

    /**
     * @param int $arrangementId
     */
    public function assignArrangement(int $arrangementId): void
    {
        $assignments = $this->arrangementAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForArrangement($arrangementId)) {
                return;
            }
        }
        $assignments[] = NotePackArrangementAssignments::create($arrangementId);
        $this->arrangementAssignments = $assignments;
    }

    /**
     * @return self[]
     */
    public function getLikeNotePacks(): array
    {
        $songIds = [];
        foreach ($this->arrangements as $arrangement) {
            $songIds[] = $arrangement->song->id;
        }
        $songIds = array_unique($songIds);
        /** @var Arrangement[] $arrangements */
        $arrangements = Arrangement::find()->where(['song_id' => $songIds])->all();
        $notePacks = [];
        foreach ($arrangements as $arrangement) {
            foreach ($arrangement->notePacks as $notePack) {
                if (!isset($notePacks[$notePack->id]) && $notePack->id != $this->id) {
                    $notePacks[$notePack->id] = $notePack;
                }
            }
        }
        return $notePacks;
    }

    public function url(): string
    {
        return Url::to(['note-pack/view', 'id' => $this->id]);
    }

    public function title(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getOfferPreviewImage(): string
    {
        /** @var ImageUploadBehavior $this */
        return $this->getThumbFileUrl('preview_image', 'cart');
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

    public function afterDelete()
    {
        TagDependency::invalidate(\Yii::$app->cache, 'notePack');
        parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(\Yii::$app->cache, 'notePack');
        parent::afterSave($insert, $changedAttributes);
    }
}
