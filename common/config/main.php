<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue',
        'common\bootstrap\SetUp',
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache',
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => 'redis',
            'retries' => 1,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'channel' => 'queue',
            'as log' => \yii\queue\LogBehavior::class,
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'timeZone' => 'Europe/Minsk',
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUR',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
        ],
    ],
];
