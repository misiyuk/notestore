<?php

namespace store\forms\manage\arrangement;

use store\entities\Arrangement;
use store\entities\ArrangementType;
use store\entities\Formats;
use store\entities\OfferType;
use store\entities\SaleOffer;
use store\entities\Song;
use store\forms\CompositeForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property UploadedFile|null $previewImage
 * @property UploadedFile|null $detailImage
 * @property string $slug
 * @property string $year
 * @property int $songId
 * @property int $formatsId
 * @property int $arrangementTypeId
 * @property int $offerTypeId
 *
 * @property SaleOfferCreateForm[] $saleOffers
 *
 * @property Arrangement $_arrangement
 */
class ArrangementCreateForm extends CompositeForm
{
    public $previewImage;
    public $detailImage;
    public $slug;
    public $year;
    public $songId;
    public $formatsId;
    public $arrangementTypeId;
    public $offerTypeId;

    public $_arrangement;

    public function __construct(Arrangement $arrangement = null, array $config = [])
    {
        if ($arrangement) {
            $this->slug = $arrangement->slug;
            $this->year = $arrangement->year;
            $this->songId = $arrangement->song_id;
            $this->formatsId = $arrangement->formats_id;
            $this->arrangementTypeId = $arrangement->arrangement_type_id;
            $this->offerTypeId = $arrangement->offer_type_id;
            $this->saleOffers = array_map(function(SaleOffer $saleOffer) {
                return new SaleOfferCreateForm($saleOffer);
            }, $arrangement->saleOffers);
            $this->_arrangement = $arrangement;
        } else {
            $this->saleOffers = SaleOfferCreateForm::getCreateModels();
        }
        parent::__construct($config);
    }

    public function songList()
    {
        return ArrayHelper::map(Song::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function formatsList()
    {
        return ArrayHelper::map(Formats::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function arrangementTypeList()
    {
        return ArrayHelper::map(ArrangementType::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function offerTypeList()
    {
        return ArrayHelper::map(OfferType::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function rules(): array
    {
        return [
            [['slug', 'songId', 'formatsId', 'arrangementTypeId', 'offerTypeId', 'previewImage', 'detailImage'], 'required'],
            [['slug'], 'string', 'max' => 255],
            [['year'], 'integer', 'max' => date('Y'), 'min' => -2018],
            [['songId', 'formatsId', 'arrangementTypeId', 'offerTypeId'], 'integer'],
            [['slug'], 'unique', 'targetClass' => Arrangement::class, 'filter' => $this->_arrangement ? ['<>', 'id', $this->_arrangement->id] : null],
            [['previewImage', 'detailImage'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg'],
        ];
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
