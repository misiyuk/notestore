<?php

namespace store\repositories;

use store\entities\Order;

class OrderRepository
{
    /**
     * @param int $id
     * @return Order
     */
    public function get(int $id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new \DomainException('Order is not found.');
        }
        return $order;
    }

    /**
     * @param Order $order
     */
    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Order saving error.');
        }
    }

    /**
     * @param Order $order
     * @throws \Exception|\Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Removing order error.');
        }
    }
}