<?php

namespace store\forms\manage\order;

use store\entities\Order;
use yii\base\Model;

/**
 * Class OrderForm
 * @package store\forms\manage\order
 * @property Order $_order
 * @property string $fio
 * @property string $phone
 * @property string $email
 */
class OrderForm extends Model
{
    public $fio;
    public $phone;
    public $email;

    public function __construct(Order $order = null, $config = [])
    {
        if ($order) {
            $this->fio = $order->fio;
            $this->phone = $order->phone;
            $this->email = $order->email;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['fio', 'phone', 'email'], 'required'],
            [['fio', 'phone', 'email'], 'string'],
        ];
    }
}