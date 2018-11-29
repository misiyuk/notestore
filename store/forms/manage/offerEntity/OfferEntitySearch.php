<?php

namespace store\forms\manage\offerEntity;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\OfferEntity;

/**
 * Class OfferEntitySearch
 * @package store\forms\manage\offerEntity
 *
 * @property int $id
 * @property string $name
 */
class OfferEntitySearch extends Model
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
        $query = OfferEntity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
