<?php

namespace store\forms\manage\song;

use store\entities\Film;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use store\entities\Song;

/**
 * @property array $ids
 */
class FilmForm extends Model
{
    public $ids;

    public function __construct(Song $song = null, array $config = [])
    {
        if ($song) {
            $this->ids = ArrayHelper::getColumn($song->filmAssignments, 'film_id');
        }
        parent::__construct($config);
    }

    public function filmList(): array
    {
        return ArrayHelper::map(Film::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function rules(): array
    {
        return [
            ['ids', 'each', 'rule' => ['integer']],
            ['ids', 'default', 'value' => []],
        ];
    }
}
