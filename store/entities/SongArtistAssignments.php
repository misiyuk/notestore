<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $song_id;
 * @property integer $artist_id;
 */
class SongArtistAssignments extends ActiveRecord
{
    public static function create($artistId): self
    {
        $assignment = new static();
        $assignment->artist_id = $artistId;
        return $assignment;
    }

    public function isForArtist($id): bool
    {
        return $this->artist_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%song_artist_assignments}}';
    }
}
