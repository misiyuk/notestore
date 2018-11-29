<?php

namespace store\forms\frontend;

use store\entities\Arrangement;
use store\entities\ArrangementType;
use store\entities\NotePack;
use store\entities\NotePackArrangementAssignments;
use store\entities\OfferEntity;
use store\entities\SaleOffer;
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
 * @property int $minPrice
 * @property int $maxPrice
 *
 * @property int $minPriceInterval
 * @property int $maxPriceInterval
 * @property ArrangementType[] $arrangementTypeList
 * @property array $yearList
 * @property int $arrangementTypeCount
 * @property int $yearCount
 *
 * @property OfferEntity $_offerEntity
 */
class NotePackFilterForm extends Model
{
    public $year = [];
    public $arrangementType = [];
    public $minPrice;
    public $maxPrice;

    private $_offerEntity;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_offerEntity = (new NotePack())->offerEntity;
    }

    public function rules(): array
    {
        return [
            [['arrangementType', 'year'], 'each', 'rule' => ['integer']],
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
            ->where(['offer_entity_id' => $this->_offerEntity->id])
            ->max('price');
    }

    /**
     * @param array $params
     * @param int $limit
     * @return ActiveDataProvider
     */
    public function getAll(array $params, int $limit = 16): ActiveDataProvider
    {
        $query = NotePack::find();
        $query->joinWith('mainSaleOffer as mainSaleOffer');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => ['price', 'view_count', 'id'],
            ],
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]);

        $this->load($params);
        if ($this->validate()) {
            $this->addYearFilter($query);
            $this->addArrangementTypeFilter($query);
            $this->addPriceFilter($query);
        }
        return $dataProvider;
    }

    private function addYearFilter(ActiveQuery $query): void
    {
        if (!empty($this->year)) {
            $arrangementQuery = Arrangement::find()
                ->select('note_pack_id')
                ->alias('arrangement')
                ->leftJoin(NotePackArrangementAssignments::tableName() . ' as assignments', 'assignments.arrangement_id = arrangement.id')
                ->andWhere([
                    'arrangement.year' => $this->year
                ])
                ->asArray();
            $notePackIds = array_unique(ArrayHelper::getColumn($arrangementQuery->all(), 'note_pack_id'));
            $query->andWhere([
                NotePack::tableName() . '.id' => !empty($notePackIds) ? $notePackIds : 0
            ]);
        }
    }

    private function addArrangementTypeFilter(ActiveQuery $query): void
    {
        if (!empty($this->arrangementType)) {
            $arrangementQuery = Arrangement::find()
                ->select('note_pack_id')
                ->alias('arrangement')
                ->leftJoin(NotePackArrangementAssignments::tableName() . ' as assignments', 'assignments.arrangement_id = arrangement.id')
                ->andWhere([
                    'arrangement.arrangement_type_id' => $this->arrangementType
                ])
                ->asArray();
            $notePackIds = array_unique(ArrayHelper::getColumn($arrangementQuery->all(), 'note_pack_id'));
            $query->andWhere([
                NotePack::tableName() . '.id' => !empty($notePackIds) ? $notePackIds : 0
            ]);
        }
    }

    private function addPriceFilter(ActiveQuery $query): void
    {
        if ($this->minPrice !== null || $this->maxPrice !== null) {
            $saleOfferQuery = SaleOffer::find()
                ->select('offer_id')
                ->where([
                    'offer_entity_id' => $this->_offerEntity->id,
                ]);
            if ($this->minPrice !== null) {
                $saleOfferQuery->andWhere(['>=', 'price', $this->minPrice]);
            }
            if ($this->maxPrice !== null) {
                $saleOfferQuery->andWhere(['<=', 'price', $this->maxPrice]);
            }
            $saleOffers = array_unique(ArrayHelper::getColumn($saleOfferQuery->asArray()->all(), 'offer_id'));

            $query->andWhere([
                NotePack::tableName() . '.id' => !empty($saleOffers) ? $saleOffers : 0
            ]);
        }
    }
}
