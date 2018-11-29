<?php

namespace store\forms\manage\song;

use store\entities\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Song;
use yii\helpers\ArrayHelper;

/**
 * Class SongSearch
 * @package store\forms\manage\song
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $createdUser
 * @property string $updatedUser
 */
class SongSearch extends Model
{
    public $id;
    public $name;
    public $text;
    public $createdUser;
    public $updatedUser;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'text', 'createdUser', 'updatedUser'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Song::find()->joinWith(['createdUser as createdUser', 'updatedUser as updatedUser']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'updated_at' => [
                        'asc' => ['updated_at' => SORT_ASC],
                        'desc' => ['updated_at' => SORT_DESC],
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_ASC],
                        'desc' => ['created_at' => SORT_DESC],
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
        $query->andFilterWhere(['like', 'text', $this->text]);
        $query->andWhere([
            'created_user_id' => ArrayHelper::getColumn(User::find()
                ->andFilterWhere(['like', 'username', $this->createdUser])
                ->all(),
                'id'
            )
        ]);
        $query->andWhere([
            'updated_user_id' => ArrayHelper::getColumn(User::find()
                ->andFilterWhere(['like', 'username', $this->updatedUser])
                ->all(),
                'id'
            )
        ]);

        return $dataProvider;
    }
}
