<?php

namespace store\forms\manage\song;

use store\entities\Genre;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use store\entities\Song;

/**
 * @property array $ids
 */
class GenreForm extends Model
{
    public $ids;

    public function __construct(Song $song = null, array $config = [])
    {
        if ($song) {
            $this->ids = ArrayHelper::getColumn($song->genreAssignments, 'genre_id');
        }
        parent::__construct($config);
    }

    public function genreList(): array
    {
        return ArrayHelper::map(Genre::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function rules(): array
    {
        return [
            ['ids', 'each', 'rule' => ['integer']],
            ['ids', 'default', 'value' => []],
        ];
    }
}