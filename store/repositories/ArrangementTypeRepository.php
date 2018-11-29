<?php

namespace store\repositories;

use store\entities\ArrangementType;

class ArrangementTypeRepository
{
    /**
     * @param $id
     * @return ArrangementType
     */
    public function get($id): ArrangementType
    {
        if (!$arrangementType = ArrangementType::findOne($id)) {
            throw new \DomainException('Arrangement type is not found.');
        }
        return $arrangementType;
    }

    /**
     * @param ArrangementType $arrangementType
     */
    public function save(ArrangementType $arrangementType): void
    {
        if (!$arrangementType->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param ArrangementType $arrangementType
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(ArrangementType $arrangementType): void
    {
        if (!$arrangementType->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
