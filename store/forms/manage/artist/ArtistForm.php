<?php

namespace store\forms\manage\artist;

use store\entities\Artist;
use store\entities\Genre;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class ArtistForm
 * @package store\forms\manage\artist
 * @property Artist $_artist
 * @property string $name
 * @property string $slug
 * @property array $genreIds
 * @property string $description
 * @property UploadedFile $previewImage
 * @property UploadedFile $detailImage
 */
class ArtistForm extends Model
{
    public $name;
    public $slug;
    public $genreIds;
    public $description;
    public $previewImage;
    public $detailImage;

    private $_artist;

    public function __construct(Artist $artist = null, array $config = [])
    {
        if ($artist) {
            $this->name = $artist->name;
            $this->slug = $artist->slug;
            $this->genreIds = ArrayHelper::getColumn($artist->genres, 'id');
            $this->description = $artist->description;

            $this->_artist = $artist;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug', 'description'], 'required'],
            [['genreIds'], 'each', 'rule' => ['integer']],
            [['genreIds'], 'default', 'value' => []],
            [['name', 'slug'], 'unique', 'targetClass' => Artist::class, 'filter' => $this->_artist ? ['<>', 'id', $this->_artist->id] : null],
            [['name', 'slug', 'description'], 'string'],
            [['previewImage', 'detailImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg'],
        ];
    }

    public function genreList(): array
    {
        return ArrayHelper::map(Genre::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->previewImage = UploadedFile::getInstance($this, 'previewImage');
            $this->detailImage = UploadedFile::getInstance($this, 'detailImage');
            return true;
        }
        return false;
    }
}
