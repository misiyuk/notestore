<?php

namespace store\forms\frontend;

use store\entities\Artist;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Class ArtistFilterForm
 * @package store\forms\frontend
 *
 * @property string $query
 */
class ArtistFilterForm extends Model
{
    public $query;

    public function rules(): array
    {
        return [
            [['query'], 'string', 'max' => 255],
        ];
    }

    public function filter(array $params, int $limit = 16): ActiveDataProvider
    {
        $query = Artist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', new Expression('UPPER(name)'), mb_strtoupper($this->query)]);

        return $dataProvider;
    }
}