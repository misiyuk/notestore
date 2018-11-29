<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $song_id;
 * @property integer $arrangement_id;
 */
class SongArrangementAssignments extends ActiveRecord
{
    public static function create($arrangementId): self
    {
        $assignment = new static();
        $assignment->arrangement_id = $arrangementId;
        return $assignment;
    }

    public function isForArrangement($id): bool
    {
        return $this->arrangement_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%song_arrangement_assignments}}';
    }
}
