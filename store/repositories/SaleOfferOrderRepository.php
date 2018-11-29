<?php

namespace store\repositories;

use store\entities\SaleOfferOrder;

class SaleOfferOrderRepository
{
    /**
     * @param int $id
     * @return SaleOfferOrder
     */
    public function get(int $id): SaleOfferOrder
    {
        if (!$saleOfferOrder = SaleOfferOrder::findOne($id)) {
            throw new \DomainException('Sale Offer Order is not found.');
        }
        return $saleOfferOrder;
    }

    /**
     * @param SaleOfferOrder $saleOfferOrder
     */
    public function save(SaleOfferOrder $saleOfferOrder): void
    {
        if (!$saleOfferOrder->save()) {
            throw new \RuntimeException('Sale Offer Order saving error.');
        }
    }

    /**
     * @param SaleOfferOrder $saleOfferOrder
     * @throws \Exception|\Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(SaleOfferOrder $saleOfferOrder): void
    {
        if (!$saleOfferOrder->delete()) {
            throw new \RuntimeException('Removing sale offer order error.');
        }
    }
}