<?php

namespace frontend\bootstrap;

use store\clientEntities\ArrangementViewed;
use store\clientEntities\Cart;
use store\clientEntities\NotePackViewed;
use store\clientEntities\storage\CookieStorage;
use yii\base\BootstrapInterface;
use yii\caching\TagDependency;

class SetUp implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(ArrangementViewed::class, function () use ($app) {
            $storage = new CookieStorage('arrangementViewed', 3600 * 24);
            return new ArrangementViewed($storage);
        });
        $container->setSingleton(NotePackViewed::class, function () use ($app) {
            $storage = new CookieStorage('notePackViewed', 3600 * 24);
            return new NotePackViewed($storage);
        });
        /** @var Cart $cart */
        $cart = \Yii::$container->get(Cart::class);
        $app->view->params['cartCount'] = $app->cache->getOrSet('cartCount', function () use ($cart) {
            return $cart->getCount();
        }, 3600, new TagDependency(['tags' => 'cart']));
        $app->view->params['cartPrice'] = $app->cache->getOrSet('cartPrice', function () use ($cart) {
            return $cart->getPrice();
        }, 3600, new TagDependency(['tags' => 'cart']));
    }
}