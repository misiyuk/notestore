<?php

namespace store\readModels;

use store\entities\Arrangement;
use store\entities\ArrangementType;
use store\entities\Genre;
use store\entities\SaleOffer;
use store\entities\Song;
use store\entities\SongGenreAssignments;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\widgets\FragmentCache;

/**
 * Class ArrangementReadModel
 * @package store\readModels
 * @property ArrangementType[] $arrangementTypes
 * @property Genre[] $genres
 * @property array $years
 * @property array $priceInterval
 * @property array $filterData
 */
class ArrangementReadModel extends Component
{
    /**
     * @param int $limit
     * @return Arrangement[]
     */
    public function getPopular($limit = 5): array
    {
        return Arrangement::find()
            ->orderBy(['view_count' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    /**
     * @param int $limit
     * @return Arrangement[]
     */
    public function getNew($limit = 5): array
    {
        return Arrangement::find()
            ->orderBy('updated_at')
            ->limit($limit)
            ->all();
    }

    /**
     * @param ActiveQuery $query
     * @param Request $request
     */
    private function addYearFilterQuery(ActiveQuery $query, Request $request): void
    {
        if ($request->get('year')) {
            $query->where(['year' => $request->get('year')]);
        }
    }

    /**
     * @param ActiveQuery $query
     * @param Request $request
     */
    private function addArrangementTypeFilterQuery(ActiveQuery $query, Request $request): void
    {
        if ($request->get('arrangementType')) {
            $query->andWhere([
                'arrangement_type_id' => $request->get('arrangementType')
            ]);
        }
    }

    /**
     * @param ActiveQuery $query
     * @param Request $request
     */
    private function addGenreFilterQuery(ActiveQuery $query, Request $request): void
    {
        if ($request->get('genre')) {
            $songIds = Song::find()
                ->alias('song')
                ->select('song.id')
                ->leftJoin(SongGenreAssignments::tableName() . ' as assignments', 'assignments.song_id = song.id')
                ->andWhere(['assignments.genre_id' => $request->get('genre')])
                ->asArray()
                ->all();
            $query->andWhere([
                'song_id' => ArrayHelper::getColumn($songIds, 'id'),
            ]);
        }
    }

    /**
     * @param ActiveQuery $query
     * @param Request $request
     */
    private function addPriceFilterQuery(ActiveQuery $query, Request $request): void
    {
        $minPrice = $request->get('minPrice');
        $maxPrice = $request->get('maxPrice');
        if ($minPrice || $maxPrice) {
            $saleOfferQuery = SaleOffer::find()->select('offer_id')->where([
                'offer_entity_id' => (new Arrangement())->offerEntity->id,
            ]);
            if ($minPrice) {
                $saleOfferQuery->andWhere(['>=', 'price', $minPrice]);
            }
            if ($maxPrice) {
                $saleOfferQuery->andWhere(['<=', 'price', $maxPrice]);
            }
            $saleOffers = ArrayHelper::getColumn($saleOfferQuery->asArray()->all(), 'offer_id');
            $query->andWhere(['id' => array_unique($saleOffers)]);
        }
    }
    /**
     * @param int $limit
     * @return ActiveDataProvider
     */
    public function getAll($limit = 16): ActiveDataProvider
    {
        $request = \Yii::$app->request;
        $query = Arrangement::find();
        $this->addYearFilterQuery($query, $request);
        $this->addArrangementTypeFilterQuery($query, $request);
        $this->addGenreFilterQuery($query,$request);
        $this->addPriceFilterQuery($query,$request);
        return $this->getProvider($query, $limit);
    }


    /**
     * @param ActiveQuery $query
     * @param int $limit
     * @return ActiveDataProvider
     */
    private function getProvider(ActiveQuery $query, $limit = 16): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]);
    }

    public function getPriceInterval(): array
    {
        $arrangementEntityId = (new Arrangement())->offerEntity->id;
        $prices = [
            'min' => SaleOffer::find()
                ->where(['offer_entity_id' => $arrangementEntityId])
                ->min('price'),
            'max' => SaleOffer::find()
                ->where(['offer_entity_id' => $arrangementEntityId])
                ->max('price'),
        ];
        return $prices;
    }

    public function getYears(): array
    {
        $query = Arrangement::find();
        $query->select('year');
        $query->groupBy('year');
        $query->orderBy('year');
        $query->asArray();
        return ArrayHelper::getColumn($query->all(), 'year');
    }

    /**
     * @return ArrangementType[]
     */
    public function getArrangementTypes(): array
    {
        return ArrangementType::find()->all();
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        return Genre::find()->all();
    }

    public function getFilterData($type = 'list'): array
    {
        $result = [
            'priceInterval' => $this->priceInterval,
            'years' => $this->years,
        ];
        if ($type == 'list') {
            $result['arrangementTypes'] = $this->arrangementTypes;
        } elseif ($type == 'genre') {
            $result['genres'] = $this->genres;
        }
        return $result;
    }
}