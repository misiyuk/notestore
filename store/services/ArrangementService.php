<?php

namespace store\services;

use store\entities\Arrangement;
use store\forms\manage\arrangement\ArrangementCreateForm;
use store\forms\manage\arrangement\ArrangementUpdateForm;
use store\repositories\ArrangementRepository;
use store\repositories\NotePackRepository;
use store\repositories\SaleOfferRepository;
use yii\web\User;

/**
 * @property User $user
 * @property ArrangementRepository $arrangement
 * @property SaleOfferRepository $saleOffer
 * @property NotePackRepository $notePack
 * @property TransactionManager $transaction
 */
class ArrangementService
{
    public $user;
    public $arrangement;
    public $notePack;
    public $transaction;

    public function __construct(
        User $user,
        ArrangementRepository $arrangement,
        NotePackRepository $notePack,
        SaleOfferRepository $saleOffer,
        TransactionManager $transaction
    )
    {
        $this->user = $user;
        $this->arrangement = $arrangement;
        $this->notePack = $notePack;
        $this->saleOffer = $saleOffer;
        $this->transaction = $transaction;
    }

    /**
     * @param ArrangementCreateForm $form
     * @return Arrangement
     * @throws \Exception
     */
    public function create(ArrangementCreateForm $form): Arrangement
    {
        $arrangement = Arrangement::create(
            $form->previewImage,
            $form->detailImage,
            $form->slug,
            $form->year,
            $form->arrangementTypeId,
            $form->formatsId,
            $form->songId,
            $form->offerTypeId,
            $this->user->id
        );

        $this->transaction->wrap(function () use ($form, $arrangement) {
            $this->arrangement->save($arrangement);
            foreach ($form->saleOffers as $saleOfferForm) {
                $arrangement->setSaleOffer(
                    $saleOfferForm->file,
                    $saleOfferForm->offerTypeId,
                    $saleOfferForm->price,
                    $this->user->id
                );
            }
            $this->arrangement->save($arrangement);
            $this->notePack->recalculatePrice($arrangement->notePacks, $this->user->id);
        });
        return $arrangement;
    }

    /**
     * @param int $id
     * @param ArrangementUpdateForm $form
     * @throws \Exception
     */
    public function edit(int $id, ArrangementUpdateForm $form): void
    {
        $arrangement = $this->arrangement->get($id);

        $this->editSaleOffers($arrangement, $form);

        $arrangement->edit(
            $form->previewImage,
            $form->detailImage,
            $form->slug,
            $form->year,
            $form->arrangementTypeId,
            $form->formatsId,
            $form->songId,
            $form->offerTypeId,
            $this->user->id
        );

        $this->transaction->wrap(function () use ($arrangement) {
            $this->arrangement->save($arrangement);
            $this->notePack->recalculatePrice($arrangement->notePacks, $this->user->id);
        });
    }

    /**
     * @param Arrangement $arrangement
     * @param ArrangementUpdateForm $form
     * @throws \Exception
     */
    public function editSaleOffers(Arrangement $arrangement, ArrangementUpdateForm $form): void
    {
        foreach ($arrangement->saleOffers as $saleOffer) {
            foreach ($form->saleOffers as $saleOfferUpdateForm) {
                if ($saleOfferUpdateForm->offerTypeId == $saleOffer->offer_type_id) {
                    $arrangement->setSaleOffer(
                        $saleOfferUpdateForm->file,
                        $saleOfferUpdateForm->offerTypeId,
                        $saleOfferUpdateForm->price,
                        $this->user->id
                    );
                }
            }
        }
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function remove(int $id): void
    {
        $arrangement = $this->arrangement->get($id);
        $notePacks = $arrangement->notePacks;
        $this->transaction->wrap(function () use ($notePacks, $arrangement) {
            foreach ($arrangement->saleOffers as $saleOffer) {
                $this->saleOffer->remove($saleOffer);
            }
            $this->arrangement->remove($arrangement);
            $this->notePack->recalculatePrice($notePacks, $this->user->id);
        });
    }
}