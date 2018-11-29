<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $song_id;
 * @property integer $film_id;
 */
class SongFilmAssignments extends ActiveRecord
{
    public static function create(int $filmId): self
    {
        $assignment = new static();
        $assignment->film_id = $filmId;
        return $assignment;
    }

    public function isForFilm(int $id): bool
    {
        return $this->film_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%song_film_assignments}}';
    }
}
