<?php

namespace store\repositories;

use store\entities\OfferType;

class OfferTypeRepository
{
    /**
     * @param $id
     * @return OfferType
     */
    public function get($id): OfferType
    {
        if (!$offerType = OfferType::findOne($id)) {
            throw new \DomainException('Arrangement type is not found.');
        }
        return $offerType;
    }

    /**
     * @param OfferType $offerType
     */
    public function save(OfferType $offerType): void
    {
        if (!$offerType->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param OfferType $offerType
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(OfferType $offerType): void
    {
        if (!$offerType->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
