<?php

namespace store\repositories;

use store\entities\Arrangement;
use store\entities\NotePack;
use store\entities\SaleOffer;
use yii\helpers\ArrayHelper;

class NotePackRepository
{
    public function get($id): NotePack
    {
        if (!$notePack = NotePack::findOne($id)) {
            throw new \DomainException('Note pack is not found.');
        }
        return $notePack;
    }

    public function save(NotePack $notePack): void
    {
        if (!$notePack->save()) {
            throw new \RuntimeException('Note pack saving error.');
        }
    }

    /**
     * @param NotePack $notePack
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(NotePack $notePack): void
    {
        if (!$notePack->delete()) {
            throw new \RuntimeException('Removing note pack error.');
        }
    }

    public function getPrice(NotePack $notePack, $offerTypeId): float
    {
        /** @var SaleOffer[] $saleOffers */
        $arrangementIds = ArrayHelper::getColumn($notePack->arrangementAssignments, 'arrangement_id');
        $saleOffers = SaleOffer::find()
            ->where([
                'offer_type_id' => $offerTypeId,
                'offer_id' => !empty($arrangementIds) ? $arrangementIds : 0,
                'offer_entity_id' => (new Arrangement())->offerEntity->id
            ])
            ->all();
        $price = 0;
        foreach ($saleOffers as $saleOffer) {
            $price += $saleOffer->price;
        }
        return $price;
    }

    /**
     * @param NotePack[] $notePacks
     * @param int $userId
     */
    public function recalculatePrice(array $notePacks, $userId): void
    {
        foreach ($notePacks as $notePack) {
            $saleOffers = $notePack->saleOffers;
            foreach ($saleOffers as $saleOffer) {
                $saleOffer->edit(
                    null,
                    $saleOffer->offer_type_id,
                    $this->getPrice($notePack, $saleOffer->offer_type_id),
                    $userId
                );
            }
            $notePack->saleOffers = $saleOffers;
            $this->save($notePack);
        }
    }
}