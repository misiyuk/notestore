<?php

namespace store\services;

use store\entities\ArrangementType;
use store\forms\manage\arrangementType\ArrangementTypeForm;
use store\repositories\ArrangementTypeRepository;

/**
 * @property ArrangementTypeRepository $arrangementType
 */
class ArrangementTypeService
{
    private $arrangementType;

    /**
     * ArrangementTypeService constructor.
     * @param ArrangementTypeRepository $arrangementType
     */
    public function __construct(ArrangementTypeRepository $arrangementType)
    {
        $this->arrangementType = $arrangementType;
    }

    /**
     * @param ArrangementTypeForm $form
     * @return ArrangementType
     */
    public function create(ArrangementTypeForm $form): ArrangementType
    {
        $arrangementType = ArrangementType::create($form->name);
        $this->arrangementType->save($arrangementType);
        return $arrangementType;
    }

    /**
     * @param $id
     * @param ArrangementTypeForm $form
     */
    public function edit($id, ArrangementTypeForm $form): void
    {
        $genre = $this->arrangementType->get($id);
        $genre->edit($form->name);
        $this->arrangementType->save($genre);
    }

    /**
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $arrangementType = $this->arrangementType->get($id);
        $this->arrangementType->remove($arrangementType);
    }
}