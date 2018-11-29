<?php

namespace store\helpers;

class PriceHelper
{
    public static function asCurrency($price): string
    {
        return \Yii::$app->formatter->asCurrency($price);
    }
}