<?php

namespace store\services;


class TransactionManager
{
    /**
     * @param callable $function
     * @throws \Exception
     */
    public function wrap(callable $function): void
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $function();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}