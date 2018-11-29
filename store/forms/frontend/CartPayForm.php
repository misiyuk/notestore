<?php

namespace store\forms\frontend;

use yii\base\Model;

/**
 * Class CartForm
 * @package store\forms\frontend
 *
 * @property string $email
 * @property bool $check
 */
class CartPayForm extends Model
{
    public $email;
    public $check;

    public function rules(): array
    {
        return [
            [['email', 'check'], 'required'],
            [['email'], 'string'],
            [['check'], 'boolean'],
        ];
    }
}