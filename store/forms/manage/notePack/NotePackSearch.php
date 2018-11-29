<?php

namespace store\forms\manage\notePack;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\NotePack;

/**
 * Class NotePackSearch
 * @package store\forms\manage\notePack
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $discount
 * @property string $description
 */
class NotePackSearch extends Model
{
    public $id;
    public $name;
    public $slug;
    public $discount;
    public $description;

    public function rules(): array
    {
        return [
            [['id', 'discount'], 'integer'],
            [['name', 'slug', 'description'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = NotePack::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
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
            'like', 'name', $this->name,
        ]);

        $query->andFilterWhere([
            'like', 'slug', $this->slug,
        ]);

        $query->andFilterWhere([
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere([
            'like', 'description', $this->description,
        ]);

        return $dataProvider;
    }
}
