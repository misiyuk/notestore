<?php

namespace store\forms\manage\notePack;

use store\entities\OfferType;
use store\entities\SaleOffer;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property UploadedFile $file
 * @property int $offerTypeId
 *
 * @property SaleOffer $_saleOffer
 */
class SaleOfferCreateForm extends Model
{
    private static $formIndex = 0;

    public $file;
    public $offerTypeId;

    public $_saleOffer;

    public function __construct(SaleOffer $saleOffer, array $config = [])
    {
        $this->offerTypeId = $saleOffer->offer_type_id;
        $this->_saleOffer = $saleOffer;
        parent::__construct($config);
    }

    public function offerTypeList(): array
    {
        return ArrayHelper::map(OfferType::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    /**
     * @return SaleOfferCreateForm[]
     */
    public static function getCreateModels(): array
    {
        return array_map(function(OfferType $offerType) {
            $saleOffer = new SaleOffer();
            $saleOffer->offer_type_id = $offerType->id;
            return new self($saleOffer);
        }, OfferType::getAll());
    }

    public function getOfferType(): string
    {
        return $this->_saleOffer->offerType->name;
    }

    public function rules(): array
    {
        return [
            [['offerTypeId', 'file'], 'required'],
            [['offerTypeId'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, '[' . self::$formIndex++ . ']file');
            return true;
        }
        return false;
    }
}
