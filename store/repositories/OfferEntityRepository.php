<?php

namespace store\repositories;

use store\entities\OfferEntity;

class OfferEntityRepository
{
    /**
     * @param $id
     * @return OfferEntity
     */
    public function get($id): OfferEntity
    {
        if (!$offerEntity = OfferEntity::findOne($id)) {
            throw new \DomainException('Arrangement entity is not found.');
        }
        return $offerEntity;
    }

    /**
     * @param OfferEntity $offerEntity
     */
    public function save(OfferEntity $offerEntity): void
    {
        if (!$offerEntity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param OfferEntity $offerEntity
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(OfferEntity $offerEntity): void
    {
        if (!$offerEntity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
