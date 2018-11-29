<?php

namespace store\forms\manage\genre;

use store\entities\Genre;
use yii\base\Model;

/**
 * @property string $name
 * @property Genre $_genre
 */
class GenreForm extends Model
{
    public $name;

    private $_genre;

    public function __construct(Genre $genre = null, array $config = [])
    {
        if ($genre) {
            $this->name = $genre->name;

            $this->_genre = $genre;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => Genre::class, 'filter' => $this->_genre ? ['<>', 'id', $this->_genre->id] : null],
            ['name', 'string'],
        ];
    }
}