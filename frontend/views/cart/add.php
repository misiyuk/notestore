<?php
/**
 * @var \yii\web\View $this
 * @var string $type
 * @var string $message
 */

echo \yii\helpers\Json::encode([
    'TYPE' => $type,
    'MESSAGE' => $message,
]);