<?php

namespace store\forms\manage\song;

use store\forms\CompositeForm;
use store\entities\Song;
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
 * @property Song $_song
 */
class SongEditForm extends CompositeForm
{
    public $name;
    public $text;
    public $video;
    public $audio;

    public $_song;

    public function __construct(Song $song, $config = [])
    {
        $this->name = $song->name;
        $this->text = $song->text;
        $this->video = $song->video;
        $this->genres = new GenreForm($song);
        $this->artists = new ArtistForm($song);
        $this->films = new FilmForm($song);
        $this->_song = $song;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Song::class, 'filter' => $this->_song ? ['<>', 'id', $this->_song->id] : null],
            [['text', 'video'], 'string'],
            ['audio', 'file', 'skipOnEmpty' => true, 'extensions' => 'mp3']
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
