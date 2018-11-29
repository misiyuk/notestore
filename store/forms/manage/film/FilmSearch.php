<?php

namespace store\forms\manage\film;

use store\entities\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Film;
use yii\helpers\ArrayHelper;

/**
 * Class FilmSearch
 * @package store\forms\manage\film
 *
 * @property int $id
 * @property string $name
 * @property string $createdUser
 * @property string $updatedUser
 */
class FilmSearch extends Model
{
    public $id;
    public $name;
    public $createdUser;
    public $updatedUser;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'createdUser', 'updatedUser'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Film::find()->joinWith(['createdUser as createdUser', 'updatedUser as updatedUser']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'created_at' => [
                        'asc' => ['created_at' => SORT_ASC],
                        'desc' => ['created_at' => SORT_DESC],
                    ],
                    'updated_at' => [
                        'asc' => ['updated_at' => SORT_ASC],
                        'desc' => ['updated_at' => SORT_DESC],
                    ],
                    'createdUser' => [
                        'asc' => ['createdUser.username' => SORT_ASC],
                        'desc' => ['createdUser.username' => SORT_DESC],
                    ],
                    'updatedUser' => [
                        'asc' => ['updatedUser.username' => SORT_ASC],
                        'desc' => ['updatedUser.username' => SORT_DESC],
                    ],
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

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->andWhere([
            'created_user_id' => ArrayHelper::getColumn(User::find()
                    ->andFilterWhere(['like', 'username', $this->createdUser])
                    ->all(),
                    'id'
                )
        ]);

        $query->andWhere([
            'updated_user_id' =>
                ArrayHelper::getColumn(User::find()
                    ->andFilterWhere(['like', 'username', $this->updatedUser])
                    ->all(),
                    'id'
                )
        ]);
        return $dataProvider;
    }
}
