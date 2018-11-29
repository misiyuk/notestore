<?php

namespace store\forms\manage\artist;

use store\entities\Genre;
use store\entities\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\Artist;
use yii\helpers\ArrayHelper;

/**
 * Class ArtistSearch
 * @package store\forms\manage\artist
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $genre
 * @property string $createdUser
 * @property string $updatedUser
 */
class ArtistSearch extends Model
{
    public $id;
    public $name;
    public $slug;
    public $description;
    public $genre;
    public $createdUser;
    public $updatedUser;

    public function rules(): array
    {
        return [
            [['id', 'genre'], 'integer'],
            [['name', 'slug', 'description', 'createdUser', 'updatedUser'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Artist::find()->joinWith(['createdUser as createdUser', 'updatedUser as updatedUser', 'genres as genre']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'genre' => [
                        'asc' => ['genre.name' => SORT_ASC],
                        'desc' => ['genre.name' => SORT_DESC],
                    ],
                    'name',
                    'slug',
                    'description',
                    'createdAt' => [
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
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'genre' => $this->genre,
            'created_user_id' => ArrayHelper::getColumn(
                User::find()
                ->andFilterWhere(['like', 'username', $this->updatedUser])
                ->all(),
                'id'
            ),
            'updated_user_id' => ArrayHelper::getColumn(
                User::find()
                ->andFilterWhere(['like', 'username', $this->createdUser])
                ->all(),
                'id'
            )
        ]);

        $query->andFilterWhere([
            'like', 'name', $this->name,
        ]);

        $query->andFilterWhere([
            'like', 'slug', $this->slug,
        ]);

        $query->andFilterWhere([
            'like', 'description', $this->description,
        ]);

        return $dataProvider;
    }

    public function genreList(): array
    {
        return ArrayHelper::map(Genre::find()->all(), 'id', 'name');
    }
}
