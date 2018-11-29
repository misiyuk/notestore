<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $song_id;
 * @property integer $arrangement_type_id;
 */
class SongArrangementTypeAssignments extends ActiveRecord
{
    public static function create($arrangementTypeId): self
    {
        $assignment = new static();
        $assignment->arrangement_type_id = $arrangementTypeId;
        return $assignment;
    }

    public function isForArrangementType($id): bool
    {
        return $this->arrangement_type_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%song_arrangement_type_assignments}}';
    }
}
