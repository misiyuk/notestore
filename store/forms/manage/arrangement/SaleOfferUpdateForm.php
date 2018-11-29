<?php

namespace store\forms\manage\arrangement;

use store\entities\OfferType;
use store\entities\SaleOffer;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property UploadedFile|null $file
 * @property int $offerTypeId
 * @property float $price
 *
 * @property SaleOffer $_saleOffer
 */
class SaleOfferUpdateForm extends Model
{
    private static $formIndex = 0;

    public $file;
    public $offerTypeId;
    public $price;

    public $_saleOffer;

    public function __construct(SaleOffer $saleOffer, array $config = [])
    {
        $this->price = $saleOffer->price;
        $this->offerTypeId = $saleOffer->offer_type_id;
        $this->_saleOffer = $saleOffer;
        parent::__construct($config);
    }

    public function offerTypeList(): array
    {
        return ArrayHelper::map(OfferType::find()->orderBy('name')->asArray()->all(), 'id','name');
    }

    public function getOfferType(): string
    {
        return $this->_saleOffer->offerType->name;
    }

    public function rules(): array
    {
        return [
            [['price', 'offerTypeId'], 'required'],
            [['offerTypeId'], 'integer'],
            [['price'], 'double'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip'],
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
