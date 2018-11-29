<?php

namespace store\entities;

use yii\db\ActiveQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%song}}".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $video
 * @property UploadedFile|string $audio
 * @property int $created_at
 * @property int $created_user_id
 * @property int $updated_at
 * @property int $updated_user_id
 *
 * @property User $createdUser
 * @property User $updatedUser
 * @property Artist[] $artists
 * @property Arrangement[] $arrangements
 * @property Genre[] $genres
 * @property Film[] $films
 * @property SongGenreAssignments[] $genreAssignments
 * @property SongArtistAssignments[] $artistAssignments
 * @property SongFilmAssignments[] $filmAssignments
 * @property string $artistsString
 */
class Song extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%song}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['genreAssignments', 'artistAssignments', 'arrangementAssignments', 'filmAssignments'],
            ],
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'audio',
                'filePath' => '@staticRoot/audio/[[id]].[[extension]]',
                'fileUrl' => '@static/audio/[[id]].[[extension]]',
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'text', 'video', 'audio', 'created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'required'],
            [['text'], 'string'],
            [['created_at', 'created_user_id', 'updated_at', 'updated_user_id'], 'integer'],
            [['name', 'video'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'video' => 'Video',
            'audio' => 'Audio',
            'created_at' => 'Created At',
            'created_user_id' => 'Created User ID',
            'updated_at' => 'Updated At',
            'updated_user_id' => 'Updated User ID',
        ];
    }

    public function getArrangements(): ActiveQuery
    {
        return $this->hasMany(Arrangement::class, ['song_id' => 'id'])->orderBy('id');
    }

    public function getArrangementTypes(): ActiveQuery
    {
        $query = $this->hasMany(ArrangementType::class, ['id' => 'arrangement_type_id']);
        $query->viaTable('{{%arrangement}}', ['song_id' => 'id']);
        $query->orderBy('id');
        return $query;
    }

    public function getArtists(): ActiveQuery
    {
        return $this->hasMany(Artist::class, ['id' => 'artist_id'])
            ->viaTable('{{%song_artist_assignments}}', ['song_id' => 'id']);
    }

    public function getArtistsString(): string
    {
        $string = '';
        foreach ($this->artists as $artist) {
            if ($string == '') {
                $string .= $artist->name;
            } else {
                $string .= ', ' . $artist->name;
            }
        }
        return $string;
    }

    public function getFilms(): ActiveQuery
    {
        return $this->hasMany(Film::class, ['id' => 'film_id'])->viaTable('{{%song_film_assignments}}', ['song_id' => 'id']);
    }

    public function getGenres(): ActiveQuery
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])->viaTable('{{%song_genre_assignments}}', ['song_id' => 'id']);
    }

    public function getCreatedUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_user_id']);
    }

    public function getUpdatedUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_user_id']);
    }

    public function getGenreAssignments(): ActiveQuery
    {
        return $this->hasMany(SongGenreAssignments::class, ['song_id' => 'id']);
    }

    public function getFilmAssignments(): ActiveQuery
    {
        return $this->hasMany(SongFilmAssignments::class, ['song_id' => 'id']);
    }

    public function getArtistAssignments(): ActiveQuery
    {
        return $this->hasMany(SongArtistAssignments::class, ['song_id' => 'id']);
    }

    public function assignGenre($id): void
    {
        $assignments = $this->genreAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForGenre($id)) {
                return;
            }
        }
        $assignments[] = SongGenreAssignments::create($id);
        $this->genreAssignments = $assignments;
    }

    public function assignFilm($id): void
    {
        $assignments = $this->filmAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForFilm($id)) {
                return;
            }
        }
        $assignments[] = SongfilmAssignments::create($id);
        $this->filmAssignments = $assignments;
    }

    public function assignArtist($id): void
    {
        $assignments = $this->artistAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForArtist($id)) {
                return;
            }
        }
        $assignments[] = SongArtistAssignments::create($id);
        $this->artistAssignments = $assignments;
    }

    /**
     * @param $name
     * @param $text
     * @param $video
     * @param UploadedFile $audio
     * @param $userId
     * @return Song
     */
    public static function create($name, $text, $video, UploadedFile $audio, $userId): self
    {
        $song = new static();
        $song->name = $name;
        $song->text = $text;
        $song->video = $video;
        $song->audio = $audio;
        $song->created_at = time();
        $song->created_user_id = $userId;
        $song->updated_at = $song->created_at;
        $song->updated_user_id = $userId;
        return $song;
    }

    /**
     * @param $name
     * @param $text
     * @param $video
     * @param null|UploadedFile|string $audio
     * @param $userId
     */
    public function edit($name, $text, $video, ?UploadedFile $audio, $userId): void
    {
        $this->name = $name;
        $this->text = $text;
        $this->video = $video;
        $this->audio = $audio ?: $this->audio;
        $this->updated_at = time();
        $this->updated_user_id = $userId;
    }

    public function revokeGenres(): void
    {
        $this->genreAssignments = [];
    }

    public function revokeArtists(): void
    {
        $this->artistAssignments = [];
    }

    public function revokeFilms(): void
    {
        $this->filmAssignments = [];
    }
}
