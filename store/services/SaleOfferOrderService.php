<?php

namespace store\services;

use store\clientEntities\Cart;
use store\entities\SaleOfferOrder;
use store\forms\frontend\CartPayForm;
use store\repositories\SaleOfferOrderRepository;

/**
 * @property SaleOfferOrderRepository $saleOfferOrder
 * @property Cart $cart
 * @property TransactionManager $transaction
 */
class SaleOfferOrderService
{
    private $saleOfferOrder;
    private $cart;
    private $transaction;

    public function __construct(
        SaleOfferOrderRepository $saleOfferOrder,
        Cart $cart,
        TransactionManager $transaction
    )
    {
        $this->saleOfferOrder = $saleOfferOrder;
        $this->cart = $cart;
        $this->transaction = $transaction;
    }

    /**
     * @param CartPayForm $form
     * @throws \Exception
     */
    public function create(CartPayForm $form): void
    {
        $saleOfferOrders = [];
        foreach ($this->cart->getItems() as $saleOffer) {
            $saleOfferOrders[] = SaleOfferOrder::create(
                $form->email,
                $saleOffer->id
            );
        }
        $this->transaction->wrap(function () use ($saleOfferOrders) {
            foreach ($saleOfferOrders as $saleOfferOrder) {
                $this->saleOfferOrder->save($saleOfferOrder);
            }
        });
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $saleOfferOrder = $this->saleOfferOrder->get($id);
        $this->saleOfferOrder->remove($saleOfferOrder);
    }
}
