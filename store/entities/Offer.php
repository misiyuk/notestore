<?php

namespace store\entities;

interface Offer extends TitleSearch
{
    public function getOfferPreviewImage(): string;
    public function description(): string;

    /**
     * @return Genre[]
     */
    public function getGenres(): array;
}
