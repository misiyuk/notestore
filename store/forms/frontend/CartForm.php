<?php

namespace store\forms\frontend;

use yii\base\Model;

/**
 * Class CartForm
 * @package store\forms\frontend
 *
 * @property int $saleOfferId
 */
class CartForm extends Model
{
    public $saleOfferId;

    public function rules(): array
    {
        return [
            ['saleOfferId', 'required'],
            ['saleOfferId', 'integer'],
        ];
    }
}