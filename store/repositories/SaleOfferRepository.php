<?php

namespace store\repositories;

use store\entities\SaleOffer;

class SaleOfferRepository
{
    public function get($id): SaleOffer
    {
        if (!$saleOffer = SaleOffer::findOne($id)) {
            throw new \DomainException('Sale Offer is not found.');
        }
        return $saleOffer;
    }

    public function save(SaleOffer $saleOffer): void
    {
        if (!$saleOffer->save()) {
            throw new \RuntimeException('Sale Offer saving error.');
        }
    }

    /**
     * @param SaleOffer $saleOffer
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(SaleOffer $saleOffer): void
    {
        if (!$saleOffer->delete()) {
            throw new \RuntimeException('Removing sale offer error.');
        }
    }
}