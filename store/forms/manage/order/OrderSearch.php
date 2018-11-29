<?php

namespace store\forms\manage\order;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Order;

/**
 * Class OrderSearch
 * @package store\forms\manage\search
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property int $createdAt
 */
class OrderSearch extends Model
{
    public $id;
    public $fio;
    public $phone;
    public $email;
    public $createdAt;

    public function rules(): array
    {
        return [
            [['id', 'createdAt'], 'integer'],
            [['fio', 'phone', 'email'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'createdAt' => [
                        'asc' => ['created_at' => SORT_ASC],
                        'desc' => ['created_at' => SORT_DESC],
                    ],
                    'email',
                    'fio',
                    'phone',
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->createdAt,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'fio', $this->fio]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
