<?php

namespace store\services;

use store\entities\NotePack;
use store\forms\manage\notePack\NotePackCreateForm;
use store\forms\manage\notePack\NotePackUpdateForm;
use store\forms\manage\notePack\SaleOfferCreateForm;
use store\repositories\ArrangementRepository;
use store\repositories\NotePackRepository;
use store\repositories\SaleOfferRepository;
use yii\web\User;

/**
 * @property NotePackRepository $notePack
 * @property User $user
 * @property SaleOfferRepository $saleOffer
 * @property ArrangementRepository $arrangement
 * @property TransactionManager $transaction
 */
class NotePackService
{
    private $user;
    private $notePack;
    private $saleOffer;
    private $arrangement;
    private $transaction;

    public function __construct(
        User $user,
        NotePackRepository $notePack,
        SaleOfferRepository $saleOffer,
        ArrangementRepository $arrangement,
        TransactionManager $transaction
    )
    {
        $this->user = $user;
        $this->notePack = $notePack;
        $this->saleOffer = $saleOffer;
        $this->arrangement = $arrangement;
        $this->transaction = $transaction;
    }

    /**
     * @param NotePackCreateForm $form
     * @return NotePack
     * @throws \Exception
     */
    public function create(NotePackCreateForm $form): NotePack
    {
        $notePack = NotePack::create(
            $form->name,
            $form->previewImage,
            $form->detailImage,
            $form->slug,
            $form->discount,
            $form->description,
            $form->offerTypeId,
            $this->user->id
        );
        $this->editArrangements($notePack, $form->arrangementIds);
        $this->transaction->wrap(function() use ($notePack, $form) {
            $this->notePack->save($notePack);
            foreach ($form->saleOffers as $saleOfferForm) {
                $notePack->setSaleOffer(
                    $saleOfferForm->file,
                    $saleOfferForm->offerTypeId,
                    $this->notePack->getPrice($notePack, $saleOfferForm->offerTypeId),
                    $this->user->id
                );
            }
            $this->notePack->save($notePack);
        });
        return $notePack;
    }

    /**
     * @param int $id
     * @param NotePackUpdateForm $form
     * @throws \Exception
     */
    public function edit(int $id, NotePackUpdateForm $form): void
    {
        $notePack = $this->notePack->get($id);

        $notePack->edit(
            $form->name,
            $form->previewImage,
            $form->detailImage,
            $form->slug,
            $form->discount,
            $form->description,
            $form->offerTypeId,
            $this->user->id
        );
        $notePack->revokeArrangements();
        $this->transaction->wrap(function() use ($notePack, $form) {
            $this->notePack->save($notePack);
            $this->editArrangements($notePack, $form->arrangementIds);
            $this->editSaleOffers($notePack, $form->saleOffers);
            $this->notePack->save($notePack);
        });
    }

    /**
     * @param NotePack $notePack
     * @param SaleOfferCreateForm[] $saleOfferForms
     * @throws \Exception
     */
    private function editSaleOffers(NotePack $notePack, array $saleOfferForms): void
    {
        foreach ($notePack->saleOffers as $saleOffer) {
            foreach ($saleOfferForms as $saleOfferForm) {
                if ($saleOfferForm->offerTypeId == $saleOffer->offer_type_id) {
                    $notePack->setSaleOffer(
                        $saleOfferForm->file,
                        $saleOfferForm->offerTypeId,
                        $this->notePack->getPrice($notePack, $saleOfferForm->offerTypeId),
                        $this->user->id
                    );
                }
            }
        }
    }

    /**
     * @param NotePack $notePack
     * @param array $arrangementIds
     * @throws \Exception
     */
    private function editArrangements(NotePack $notePack, array $arrangementIds): void
    {
        foreach ($arrangementIds as $arrangementId) {
            $arrangement = $this->arrangement->get($arrangementId);
            $notePack->assignArrangement($arrangement->id);
        }
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function remove(int $id): void
    {
        $notePack = $this->notePack->get($id);
        $this->transaction->wrap(function() use ($notePack) {
            foreach ($notePack->saleOffers as $saleOffer) {
                $this->saleOffer->remove($saleOffer);
            }
            $this->notePack->remove($notePack);
        });
    }
}
