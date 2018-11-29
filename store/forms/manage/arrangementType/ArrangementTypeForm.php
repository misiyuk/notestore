<?php

namespace store\forms\manage\arrangementType;

use store\entities\ArrangementType;
use yii\base\Model;

/**
 * Class ArrangementTypeForm
 * @package store\forms\manage\arrangementType
 * @property ArrangementType $_arrangementType
 */
class ArrangementTypeForm extends Model
{
    public $name;

    private $_arrangementType;

    public function __construct(ArrangementType $arrangementType = null, array $config = [])
    {
        if ($arrangementType) {
            $this->name = $arrangementType->name;

            $this->_arrangementType = $arrangementType;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => ArrangementType::class, 'filter' => $this->_arrangementType ? ['<>', 'id', $this->_arrangementType->id] : null],
            ['name', 'string'],
        ];
    }
}