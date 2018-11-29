<?php

namespace store\services;

use store\entities\OfferEntity;
use store\forms\manage\offerEntity\OfferEntityForm;
use store\repositories\OfferEntityRepository;

/**
 * @property OfferEntityRepository $offerEntity
 */
class OfferEntityService
{
    private $offerEntity;

    /**
     * @param OfferEntityRepository $offerEntity
     */
    public function __construct(OfferEntityRepository $offerEntity)
    {
        $this->offerEntity = $offerEntity;
    }

    /**
     * @param OfferEntityForm $form
     * @return OfferEntity
     */
    public function create(OfferEntityForm $form): OfferEntity
    {
        $offerEntity = OfferEntity::create($form->name);
        $this->offerEntity->save($offerEntity);
        return $offerEntity;
    }

    /**
     * @param $id
     * @param OfferEntityForm $form
     */
    public function edit($id, OfferEntityForm $form): void
    {
        $offerEntity = $this->offerEntity->get($id);
        $offerEntity->edit($form->name);
        $this->offerEntity->save($offerEntity);
    }

    /**
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $offerEntity = $this->offerEntity->get($id);
        $this->offerEntity->remove($offerEntity);
    }
}