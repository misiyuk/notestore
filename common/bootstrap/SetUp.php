<?php
namespace common\bootstrap;

use store\clientEntities\Cart;
use store\clientEntities\storage\CookieStorage;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(Cart::class, function () use ($app) {
            $storage = new CookieStorage('cart', 3600 * 24);
            return new Cart($storage, $app->cache);
        });
    }
}