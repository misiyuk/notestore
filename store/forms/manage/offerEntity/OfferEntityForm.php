<?php

namespace store\forms\manage\offerEntity;

use store\entities\OfferEntity;
use yii\base\Model;

/**
 * @property string $name
 * @property OfferEntity $_offerEntity
 */
class OfferEntityForm extends Model
{
    public $name;

    private $_offerEntity;

    public function __construct(OfferEntity $offerEntity = null, array $config = [])
    {
        if ($offerEntity) {
            $this->name = $offerEntity->name;

            $this->_offerEntity = $offerEntity;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => OfferEntity::class, 'filter' => $this->_offerEntity ? ['<>', 'id', $this->_offerEntity->id] : null],
            ['name', 'string'],
        ];
    }
}