<?php
/**
 * @var \yii\web\View $this
 */
echo \yii\helpers\Json::encode([
    'cartCount' => $this->params['cartCount'],
    'cartPrice' => Yii::$app->formatter->asCurrency($this->params['cartPrice']),
]);