<?php

namespace store\forms\manage\song;

use store\entities\Artist;
use store\entities\Song;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $ids
 */
class ArtistForm extends Model
{
    public $ids;

    public function __construct(Song $song = null, array $config = [])
    {
        if ($song) {
            $this->ids = ArrayHelper::getColumn($song->artistAssignments, 'artist_id');
        }
        parent::__construct($config);
    }

    public function artistList(): array
    {
        return ArrayHelper::map(Artist::find()->orderBy('name')->asArray()->all(), 'id', 'name');
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