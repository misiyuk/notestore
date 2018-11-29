<?php

namespace store\repositories;

use store\entities\Arrangement;
use store\entities\SaleOffer;

class ArrangementRepository
{
    public function get($id): Arrangement
    {
        if (!$arrangement = Arrangement::findOne($id)) {
            throw new \DomainException('Arrangement is not found.');
        }
        return $arrangement;
    }

    public function save(Arrangement $arrangement): void
    {
        if (!$arrangement->save()) {
            throw new \RuntimeException('Arrangement saving error.');
        }
    }

    /**
     * @param Arrangement $arrangement
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Arrangement $arrangement): void
    {
        if (!$arrangement->delete()) {
            throw new \RuntimeException('Removing arrangement error.');
        }
    }
}