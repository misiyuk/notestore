<?php

namespace store\forms\manage\notePack;

use store\entities\Arrangement;
use store\entities\NotePack;
use store\entities\OfferType;
use store\entities\SaleOffer;
use store\forms\CompositeForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property string $name
 * @property string $slug
 * @property int $discount
 * @property string $description
 * @property UploadedFile $previewImage
 * @property UploadedFile $detailImage
 * @property array $arrangementIds
 * @property int $offerTypeId
 *
 * @property SaleOfferCreateForm[] $saleOffers
 * @property NotePack $_notePack
 */
class NotePackCreateForm extends CompositeForm
{
    public $name;
    public $slug;
    public $discount;
    public $description;
    public $previewImage;
    public $detailImage;
    public $arrangementIds;
    public $offerTypeId;

    private $_notePack;

    public function __construct(NotePack $notePack = null, array $config = [])
    {
        if ($notePack) {
            $this->name = $notePack->name;
            $this->slug = $notePack->slug;
            $this->discount = $notePack->discount;
            $this->description = $notePack->description;
            $this->offerTypeId = $notePack->offer_type_id;
            $this->arrangementIds = ArrayHelper::getColumn($notePack->arrangements, 'id');

            $this->saleOffers = array_map(function(SaleOffer $saleOffer) {
                return new SaleOfferCreateForm($saleOffer);
            }, $notePack->saleOffers);
            $this->_notePack = $notePack;
        } else {
            $this->saleOffers = SaleOfferCreateForm::getCreateModels();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug', 'discount', 'arrangementIds', 'offerTypeId'], 'required'],
            ['slug', 'unique', 'targetClass' => NotePack::class, 'filter' => $this->_notePack ? ['<>', 'id', $this->_notePack->id] : null],
            [['slug', 'name', 'description'], 'string'],
            [['discount'], 'integer', 'max' => 99],
            [['offerTypeId'], 'integer'],
            [['previewImage', 'detailImage'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg']],
        ];
    }

    public function offerTypeList(): array
    {
        return ArrayHelper::map(OfferType::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function arrangementList(): array
    {
        /**
         * @var Arrangement[] $arrangements
         */
        $arrangements = Arrangement::find()->all();
        $arrangementList = [];
        foreach ($arrangements as $arrangement) {
            $arrangementList[$arrangement->id] = $arrangement->song->name . ' - ' . $arrangement->song->artistsString .
                ' (' . $arrangement->arrangementType->name . ')';
        }
        return $arrangementList;
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->previewImage = UploadedFile::getInstance($this, 'previewImage');
            $this->detailImage = UploadedFile::getInstance($this, 'detailImage');
            return true;
        }
        return false;
    }

    public function internalForms(): array
    {
        return ['saleOffers'];
    }
}
