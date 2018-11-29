<?php

namespace store\forms\frontend;

use store\entities\Arrangement;
use store\entities\ArrangementType;
use store\entities\Genre;
use store\entities\SaleOffer;
use store\entities\Song;
use store\entities\SongGenreAssignments;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class ArrangementFilterForm
 * @package store\forms\frontend
 *
 * @property array $arrangementType
 * @property array $year
 * @property array $genre
 * @property int $minPrice
 * @property int $maxPrice
 *
 * @property int $minPriceInterval
 * @property int $maxPriceInterval
 * @property ArrangementType[] $arrangementTypeList
 * @property Genre[] $genreList
 * @property array $yearList
 * @property int $arrangementTypeCount
 * @property int $yearCount
 * @property int $genreCount
 */
class ArrangementFilterForm extends Model
{
    public $year = [];
    public $arrangementType = [];
    public $genre = [];
    public $minPrice;
    public $maxPrice;
    public $price;

    public function rules(): array
    {
        return [
            [['arrangementType', 'year', 'genre', 'price'], 'each', 'rule' => ['integer']],
            [['minPrice', 'maxPrice'], 'integer'],
        ];
    }

    /**
     * @return ArrangementType[]
     */
    public function getArrangementTypeList(): array
    {
        return ArrangementType::find()->all();
    }

    /**
     * @return Genre[]
     */
    public function getGenreList(): array
    {
        return Genre::find()->all();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function genreIsChecked($id): bool
    {
        return in_array($id, $this->genre);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function arrangementTypeIsChecked($id): bool
    {
        return in_array($id, $this->arrangementType);
    }

    /**
     * @param int $year
     * @return bool
     */
    public function yearIsChecked($year): bool
    {
        return in_array($year, $this->year);
    }

    /**
     * @return int
     */
    public function getGenreCount(): int
    {
        return count($this->genre);
    }

    /**
     * @return int
     */
    public function getYearCount(): int
    {
        return count($this->year);
    }

    /**
     * @return int
     */
    public function getArrangementTypeCount(): int
    {
        return count($this->arrangementType);
    }

    /**
     * @return int[]
     */
    public function getYearList(): array
    {
        $query = Arrangement::find();
        $query->select('year');
        $query->groupBy('year');
        $query->orderBy('year');
        $query->asArray();
        return ArrayHelper::getColumn($query->all(), 'year');
    }

    public function getMinPriceInterval(): int
    {
        return 0;
    }

    public function getMaxPriceInterval(): ?int
    {
        return SaleOffer::find()
            ->where(['offer_entity_id' => (new Arrangement())->offerEntity->id])
            ->max('price');
    }

    /**
     * @param array $params
     * @param int $limit
     * @return ActiveDataProvider
     */
    public function getAll(array $params, int $limit = 16): ActiveDataProvider
    {
        $query = Arrangement::find();

        $query->joinWith('mainSaleOffer as mainSaleOffer');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => ['id', 'price', 'view_count'],
            ],
        ]);
        $this->load($params);

        if ($this->validate()) {
            $query->andFilterWhere([
                'year' => $this->year,
                'arrangement_type_id' => $this->arrangementType
            ]);
            $this->addPriceFilter($query);
            $this->addGenreFilter($query);
        }
        return $dataProvider;
    }

    private function addGenreFilter(ActiveQuery $query): void
    {
        if (!empty($this->genre)) {
            $songIds = array_unique(ArrayHelper::getColumn(Song::find()
                ->alias('song')
                ->select('song.id')
                ->leftJoin(SongGenreAssignments::tableName() . ' as assignments', 'assignments.song_id = song.id')
                ->andFilterWhere(['assignments.genre_id' => $this->genre])
                ->asArray()
                ->all(), 'id'));
            $query->andWhere([
                'song_id' => !empty($songIds) ? $songIds : 0,
            ]);
        }
    }

    private function addPriceFilter(ActiveQuery $query): void
    {
        if ($this->minPrice !== null || $this->maxPrice !== null) {
            $saleOfferQuery = SaleOffer::find()
                ->select('offer_id')
                ->where([
                    'offer_entity_id' => (new Arrangement())->offerEntity->id,
                ]);
            if ($this->minPrice !== null) {
                $saleOfferQuery->andWhere(['>=', 'price', $this->minPrice]);
            }
            if ($this->maxPrice !== null) {
                $saleOfferQuery->andWhere(['<=', 'price', $this->maxPrice]);
            }
            $saleOffers = array_unique(ArrayHelper::getColumn($saleOfferQuery->asArray()->all(), 'offer_id'));

            $query->andWhere([
                Arrangement::tableName() . '.id' => !empty($saleOffers) ? $saleOffers : 0
            ]);
        }
    }
}