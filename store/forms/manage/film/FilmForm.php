<?php

namespace store\forms\manage\film;

use store\entities\Film;
use yii\base\Model;

/**
 * @property string $name
 * @property Film $_film
 */
class FilmForm extends Model
{
    public $name;

    private $_film;

    public function __construct(Film $film = null, array $config = [])
    {
        if ($film) {
            $this->name = $film->name;

            $this->_film = $film;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => Film::class, 'filter' => $this->_film ? ['<>', 'id', $this->_film->id] : null],
            ['name', 'string'],
        ];
    }
}