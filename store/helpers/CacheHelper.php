<?php

namespace store\helpers;

use yii\data\ActiveDataProvider;

class CacheHelper
{
    /**
     * @param ActiveDataProvider $dataProvider
     * @param array $params
     * @return string
     */
    public static function key($dataProvider, array $params = []): string
    {
        $key = serialize([
            $dataProvider->query->createCommand()->getRawSql(),
            $params
        ]);
        return $key;
    }
}