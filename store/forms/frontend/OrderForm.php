<?php

namespace store\forms\frontend;


/**
 * Class OrderForm
 * @package store\forms\frontend
 *
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property boolean $check
 */
class OrderForm extends \store\forms\manage\order\OrderForm
{
    public $check;

    public function rules(): array
    {
        return [
            [['fio', 'phone', 'email', 'check'], 'required'],
            [['fio', 'phone'], 'string'],
            [['email'], 'email'],
            [['check'], 'in', 'range' => ['on']],
        ];
    }
}