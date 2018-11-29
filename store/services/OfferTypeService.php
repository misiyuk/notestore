<?php

namespace store\services;

use store\entities\OfferType;
use store\forms\manage\offerType\OfferTypeForm;
use store\repositories\OfferTypeRepository;

/**
 * @property OfferTypeRepository $offerType
 */
class OfferTypeService
{
    private $offerType;

    /**
     * ArrangementTypeService constructor.
     * @param OfferTypeRepository $offerType
     */
    public function __construct(OfferTypeRepository $offerType)
    {
        $this->offerType = $offerType;
    }

    /**
     * @param OfferTypeForm $form
     * @return OfferType
     */
    public function create(OfferTypeForm $form): OfferType
    {
        $offerType = OfferType::create($form->name);
        $this->offerType->save($offerType);
        return $offerType;
    }

    /**
     * @param $id
     * @param OfferTypeForm $form
     */
    public function edit($id, OfferTypeForm $form): void
    {
        $offerType = $this->offerType->get($id);
        $offerType->edit($form->name);
        $this->offerType->save($offerType);
    }

    /**
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $arrangementType = $this->offerType->get($id);
        $this->offerType->remove($arrangementType);
    }
}