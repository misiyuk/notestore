<?php

namespace store\forms\manage\offerType;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\OfferType;

/**
 * Class OfferTypeSearch
 * @package store\forms\manage\offerType
 *
 * @property int $id
 * @property string $name
 */
class OfferTypeSearch extends Model
{
    public $id;
    public $name;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = OfferType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
