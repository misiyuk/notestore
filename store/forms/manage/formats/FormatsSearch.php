<?php

namespace store\forms\manage\formats;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Formats;

/**
 * Class FormatsSearch
 * @package store\forms\manage\formats
 *
 * @property int $id
 * @property string $name
 */
class FormatsSearch extends Model
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
        $query = Formats::find();

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
