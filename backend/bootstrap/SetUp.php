<?php

namespace backend\bootstrap;

use yii\base\BootstrapInterface;
use yii\web\User;

class SetUp implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(User::class, function () use ($app) {
            return $app->user;
        });
    }
}