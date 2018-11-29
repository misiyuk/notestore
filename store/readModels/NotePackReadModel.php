<?php

namespace store\readModels;

use store\entities\NotePack;

class NotePackReadModel
{
    public function getLast($limit = 5): ?array
    {
        return NotePack::find()
            ->orderBy('created_at')
            ->limit($limit)
            ->all();
    }
}