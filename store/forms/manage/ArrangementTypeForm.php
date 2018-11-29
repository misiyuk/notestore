<?php

namespace store\forms\manage;

use store\entities\ArrangementType;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $ids
 */
class ArrangementTypeForm extends Model
{
    public $ids;

    public function arrangementTypeList(): array
    {
        return ArrayHelper::map(ArrangementType::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function rules(): array
    {
        return [
            ['ids', 'required'],
            ['ids', 'each', 'rule' => ['integer']],
            ['ids', 'default', 'value' => []],
        ];
    }
}