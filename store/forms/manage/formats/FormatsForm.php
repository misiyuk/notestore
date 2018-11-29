<?php

namespace store\forms\manage\formats;

use store\entities\Formats;
use yii\base\Model;

/**
 * @property string $name
 * @property Formats $_formats
 */
class FormatsForm extends Model
{
    public $name;

    private $_formats;

    public function __construct(Formats $film = null, array $config = [])
    {
        if ($film) {
            $this->name = $film->name;

            $this->_formats = $film;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => Formats::class, 'filter' => $this->_formats ? ['<>', 'id', $this->_formats->id] : null],
            ['name', 'string'],
        ];
    }
}