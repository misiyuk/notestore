<?php

namespace store\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $note_pack_id;
 * @property integer $arrangement_id;
 */
class NotePackArrangementAssignments extends ActiveRecord
{
    public static function create(int $arrangementId): self
    {
        $assignment = new static();
        $assignment->arrangement_id = $arrangementId;
        return $assignment;
    }

    public function isForArrangement(int $id): bool
    {
        return $this->arrangement_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%note_pack_arrangement_assignments}}';
    }
}
