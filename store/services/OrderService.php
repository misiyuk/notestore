<?php

namespace store\services;

use store\entities\Order;
use store\forms\manage\order\OrderForm;
use store\repositories\OrderRepository;

/**
 * @property OrderRepository $order
 */
class OrderService
{
    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /**
     * @param int $id
     * @param OrderForm $form
     * @throws \Exception
     */
    public function edit(int $id, OrderForm $form)
    {
        $order = $this->order->get($id);
        $order->edit(
            $form->fio,
            $form->phone,
            $form->email
        );
        $this->order->save($order);
    }

    /**
     * @param OrderForm $form
     * @return Order
     * @throws \Exception
     */
    public function create(OrderForm $form): Order
    {
        $order = Order::create(
            $form->fio,
            $form->phone,
            $form->email
        );
        $this->order->save($order);
        return $order;
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $order = $this->order->get($id);
        $this->order->remove($order);
    }
}