<?php

namespace store\forms\manage\saleOfferOrder;

use store\entities\SaleOfferOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class OrderSearch
 * @package store\forms\manage\saleOfferOrder
 *
 * @property int $id
 * @property string $email
 * @property string $saleOfferId
 * @property string $createdAt
 */
class SaleOfferOrderSearch extends Model
{
    public $id;
    public $email;
    public $saleOfferId;
    public $createdAt;

    public function rules(): array
    {
        return [
            [['id', 'createdAt', 'saleOfferId'], 'integer'],
            [['email'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = SaleOfferOrder::find();

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
                    'saleOfferId' => [
                        'asc' => ['sale_offer_id' => SORT_ASC],
                        'desc' => ['sale_offer_id' => SORT_DESC],
                    ],
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
            'sale_offer_id' => $this->saleOfferId,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
