<?php

namespace store\forms\manage\arrangement;

use store\entities\ArrangementType;
use store\entities\Song;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Arrangement;
use yii\helpers\ArrayHelper;

/**
 * Class ArrangementSearch
 * @package store\forms\manage\search
 *
 * @property int $id
 * @property string $slug
 * @property int $year
 * @property string $song
 * @property int $arrangementType
 */
class ArrangementSearch extends Model
{
    public $id;
    public $slug;
    public $year;
    public $song;
    public $arrangementType;

    public function rules(): array
    {
        return [
            [['id', 'year', 'arrangementType', 'song'], 'integer'],
            [['slug'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Arrangement::find()->joinWith(['song as song', 'arrangementType as aType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'year',
                    'arrangementType' => [
                        'asc' => ['aType.name' => SORT_ASC],
                        'desc' => ['aType.name' => SORT_DESC],
                    ],
                    'song' => [
                        'asc' => ['song.name' => SORT_ASC],
                        'desc' => ['song.name' => SORT_DESC],
                    ],
                    'slug',
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere([
            'year' => $this->year,
        ]);

        $query->andFilterWhere([
            'arrangement_type_id' => $this->arrangementType,
        ]);

        $query->andFilterWhere([
            'song_id' => $this->song,
        ]);

        $query->andFilterWhere([
            'like', 'slug', $this->slug,
        ]);

        return $dataProvider;
    }

    public function songList(): array
    {
        return ArrayHelper::map(Song::find()->all(), 'id', 'name');
    }

    public function arrangementTypeList(): array
    {
        return ArrayHelper::map(ArrangementType::find()->all(), 'id', 'name');
    }
}
