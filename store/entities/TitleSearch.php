<?php

namespace store\entities;

interface TitleSearch
{
    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function url(): string;
}