<?php

namespace store\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "{{%artist}}".
 *
 * @property int $id
 * @property string $preview_image
 * @property string $detail_image
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property Song[] $songs
 * @property User $createdUser
 * @property User $updatedUser
 * @property ArrangementType[] $arrangementTypes
 * @property Arrangement[] $arrangements
 * @property Genre[] $genres
 * @property ArtistGenreAssignments[] $genreAssignments
 * @property Artist[] $likeArtists
 */
class Artist extends \yii\db\ActiveRecord implements TitleSearch
{
    private static $arrangementsSingle;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%artist}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['genreAssignments'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'preview_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/artist/preview_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/artist/preview_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/artist/preview_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/artist/preview_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'thumb' => ['width' => 185, 'height' => 172],
                    'small' => ['width' => 60, 'height' => 60],
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'detail_image',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/artist/detail_[[id]].[[extension]]',
                'fileUrl' => '@static/origin/artist/detail_[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/artist/detail_[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/artist/detail_[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'detail' => ['width' => 324, 'height' => 381],
                    'small' => ['width' => 60, 'height' => 60],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preview_image', 'detail_image', 'name', 'slug', 'description', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
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
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    /**
     * @param ArrangementType|null $arrangementType
     * @return Arrangement[]
     */
    public function getArrangements(ArrangementType $arrangementType = null): array
    {
        $index = ($arrangementType ? $arrangementType->id : null);
        if (!isset(self::$arrangementsSingle[$index])) {
            $songIds = null;
            if ($arrangementType !== null) {
                $songQuery = $this->getSongs()
                    ->select(Song::tableName() . '.id')
                    ->leftJoin(Arrangement::tableName() . 'as arrangement', 'song_id=' . Song::tableName() . '.id')
                    ->andFilterWhere(['arrangement.arrangement_type_id' => $arrangementType->id])
                    ->asArray();
                $songIds = array_unique(ArrayHelper::getColumn($songQuery->all(), 'id'));
            }
            $arrangementQuery = Arrangement::find()
                ->with([
                    'song.artists',
                    'mainSaleOffer',
                    'arrangementType',
                ])
                ->joinWith('song.artistAssignments as assignments')
                ->andWhere(['assignments.artist_id' => $this->id])
                ->andFilterWhere(['song.id' => $songIds])
                ->andFilterWhere(['arrangement_type_id' => $arrangementType !== null ? $arrangementType->id : null]);
            self::$arrangementsSingle[$index] = $arrangementQuery->all();
        }
        return self::$arrangementsSingle[$index];
    }
    /**
     * @return ArrangementType[]
     */
    public function getArrangementTypes(): array
    {
        $arrangementTypes = [];
        foreach ($this->arrangements as $arrangement) {
            if (!isset($arrangementTypes[$arrangement->arrangement_type_id])) {
                $arrangementTypes[$arrangement->arrangementType->id] = $arrangement->arrangementType;
            }
        }
        return $arrangementTypes;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::class, ['id' => 'song_id'])->viaTable('{{%song_artist_assignments}}', ['artist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])->viaTable('{{%artist_genre_assignments}}', ['artist_id' => 'id']);
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
    public function getPreviewImage()
    {
        return $this->hasOne(Image::class, ['id' => 'preview_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailImage()
    {
        return $this->hasOne(Image::class, ['id' => 'detail_image_id']);
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param UploadedFile|null $previewImage
     * @param UploadedFile|null $detailImage
     * @param int $userId
     */
    public function edit($name, $slug, $description, ?UploadedFile $previewImage, ?UploadedFile $detailImage, $userId)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->preview_image = $previewImage ?: $this->preview_image;
        $this->detail_image = $detailImage ?: $this->detail_image;
        $this->updated_at = time();
        $this->updated_user_id = $userId;
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param UploadedFile $previewImage
     * @param UploadedFile $detailImage
     * @param int $userId
     * @return Artist
     */
    public static function create($name, $slug, $description, UploadedFile $previewImage, UploadedFile $detailImage, $userId)
    {
        $artist = new static();
        $artist->name = $name;
        $artist->slug = $slug;
        $artist->description = $description;
        $artist->preview_image = $previewImage;
        $artist->detail_image = $detailImage;
        $artist->created_at = time();
        $artist->created_user_id = $userId;
        $artist->updated_at = $artist->created_at;
        $artist->updated_user_id = $userId;
        return $artist;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenreAssignments()
    {
        return $this->hasMany(ArtistGenreAssignments::class, ['artist_id' => 'id']);
    }

    public function assignGenre($id): void
    {
        $assignments = $this->genreAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForGenre($id)) {
                return;
            }
        }
        $assignments[] = ArtistGenreAssignments::create($id);
        $this->genreAssignments = $assignments;
    }

    public function revokeGenres(): void
    {
        $this->genreAssignments = [];
    }

    /**
     * @return self[]
     */
    public function getLikeArtists(): array
    {
        $genreIds = ArrayHelper::getColumn($this->genreAssignments, 'genre_id');
        $artists = self::find()
            ->alias('artist')
            ->joinWith('genreAssignments as assignments')
            ->where(['assignments.genre_id' => $genreIds])
            ->andWhere(['<>', 'id', $this->id])
            ->limit(20)
            ->all();
        return $artists;
    }

    public function title(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return Url::to(['artist/view', 'id' => $this->id]);
    }
}
