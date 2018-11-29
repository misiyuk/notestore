<?php

namespace store\services;

use store\clientEntities\Cart;
use store\forms\frontend\CartForm;
use store\repositories\SaleOfferRepository;

/**
 * @property SaleOfferRepository $saleOffer
 * @property Cart $cart
 */
class CartService
{
    private $saleOffer;
    public $cart;

    public function __construct(Cart $cart, SaleOfferRepository $saleOffer)
    {
        $this->saleOffer = $saleOffer;
        $this->cart = $cart;
    }

    public function add(CartForm $cartForm): void
    {
        $saleOffer = $this->saleOffer->get($cartForm->saleOfferId);
        $this->cart->add($saleOffer);
    }

    public function remove($saleOfferId): void
    {
        $this->cart->remove($saleOfferId);
    }
}