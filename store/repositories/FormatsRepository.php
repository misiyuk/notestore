<?php

namespace store\repositories;

use store\entities\Formats;

class FormatsRepository
{
    /**
     * @param int $id
     * @return Formats
     */
    public function get(int $id): Formats
    {
        if (!$formats = Formats::findOne($id)) {
            throw new \DomainException('Film is not found.');
        }
        return $formats;
    }

    /**
     * @param Formats $formats
     */
    public function save(Formats $formats): void
    {
        if (!$formats->save()) {
            throw new \RuntimeException('Film saving error.');
        }
    }

    /**
     * @param Formats $formats
     * @throws \Exception|\Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Formats $formats): void
    {
        if (!$formats->delete()) {
            throw new \RuntimeException('Removing film error.');
        }
    }
}