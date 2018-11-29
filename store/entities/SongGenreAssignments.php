<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $song_id;
 * @property integer $genre_id;
 */
class SongGenreAssignments extends ActiveRecord
{
    public static function create($genreId): self
    {
        $assignment = new static();
        $assignment->genre_id = $genreId;
        return $assignment;
    }

    public function isForGenre($id): bool
    {
        return $this->genre_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%song_genre_assignments}}';
    }
}
