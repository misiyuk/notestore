<?php

namespace store\clientEntities\storage;

use store\cart\CartItem;
use store\entities\SaleOffer;
use Yii;
use yii\helpers\Json;
use yii\web\Cookie;

/**
 * Class CookieStorage
 * @package store\cart\storage
 *
 * @property string $key
 * @property int $timeout
 */
class CookieStorage implements StorageInterface
{
    private $key;
    private $timeout;

    public function __construct($key, $timeout)
    {
        $this->key = $key;
        $this->timeout = $timeout;
    }

    /**
     * Return primary keys.
     * @return int[]
     */
    public function load(): array
    {
        if ($cookie = Yii::$app->request->cookies->get($this->key)) {
            return Json::decode($cookie->value);
        }
        return [];
    }

    /**
     * @param int[] $itemIds
     */
    public function save(array $itemIds): void
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => $this->key,
            'value' => Json::encode($itemIds),
            'expire' => time() + $this->timeout,
        ]));
    }
} 