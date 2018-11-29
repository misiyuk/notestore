<?php

namespace store\clientEntities\storage;

use store\entities\SaleOffer;

interface StorageInterface
{

    /**
     * @return SaleOffer[]
     */
    public function load(): array;


    /**
     * @param SaleOffer[] $items
     */
    public function save(array $items): void;
}