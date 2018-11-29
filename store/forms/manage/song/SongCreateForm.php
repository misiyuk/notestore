<?php

namespace store\forms\manage\song;

use store\entities\Song;
use store\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * @property string $name
 * @property string $text
 * @property string $video
 * @property UploadedFile|null $audio
 *
 * @property GenreForm $genres
 * @property ArtistForm $artists
 * @property FilmForm $films
 */
class SongCreateForm extends CompositeForm
{
    public $name;
    public $text;
    public $video;
    public $audio;

    public function __construct($config = [])
    {
        $this->genres = new GenreForm();
        $this->artists = new ArtistForm();
        $this->films = new FilmForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'audio'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Song::class],
            [['text', 'video'], 'string'],
            [['audio'], 'file', 'skipOnEmpty' => false, 'extensions' => 'mp3'],
        ];
    }

    protected function internalForms(): array
    {
        return ['genres', 'artists', 'films'];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->audio = UploadedFile::getInstance($this, 'audio');
            return true;
        }
        return false;
    }
}