<?php

namespace store\forms\manage\offerType;

use store\entities\OfferType;
use yii\base\Model;

/**
 * @property OfferType $_offerType
 */
class OfferTypeForm extends Model
{
    public $name;

    private $_offerType;

    public function __construct(OfferType $offerType = null, array $config = [])
    {
        if ($offerType) {
            $this->name = $offerType->name;

            $this->_offerType = $offerType;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => OfferType::class, 'filter' => $this->_offerType ? ['<>', 'id', $this->_offerType->id] : null],
            ['name', 'string'],
        ];
    }
}