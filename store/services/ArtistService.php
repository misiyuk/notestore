<?php

namespace store\services;

use store\entities\Artist;
use store\forms\manage\artist\ArtistForm;
use store\repositories\ArtistRepository;
use store\repositories\GenreRepository;
use yii\web\User;

/**
 * @property ArtistRepository $artist
 * @property User $user
 * @property GenreRepository $genre
 * @property TransactionManager $transaction
 */
class ArtistService
{
    private $artist;
    private $user;
    private $transaction;

    public function __construct(
        ArtistRepository $artist,
        User $user,
        GenreRepository $genre,
        TransactionManager $transaction
    )
    {
        $this->user = $user;
        $this->artist = $artist;
        $this->genre = $genre;
        $this->transaction = $transaction;
    }

    /**
     * @param int $id
     * @param ArtistForm $form
     * @throws \Exception
     */
    public function edit(int $id, ArtistForm $form): void
    {
        $artist = $this->artist->get($id);
        $artist->edit(
            $form->name,
            $form->slug,
            $form->description,
            $form->previewImage,
            $form->detailImage,
            $this->user->id
        );
        $artist->revokeGenres();
        $this->transaction->wrap(function () use ($artist, $form) {
            $this->artist->save($artist);
            foreach ($form->genreIds as $genreId) {
                $genre = $this->genre->get($genreId);
                $artist->assignGenre($genre->id);
            }
            $this->artist->save($artist);
        });
    }

    /**
     * @param ArtistForm $form
     * @return Artist
     * @throws \Exception
     */
    public function create(ArtistForm $form): Artist
    {
        $artist = Artist::create(
            $form->name,
            $form->slug,
            $form->description,
            $form->previewImage,
            $form->detailImage,
            $this->user->id
        );

        foreach ($form->genreIds as $genreId) {
            $genre = $this->genre->get($genreId);
            $artist->assignGenre($genre->id);
        }
        $this->artist->save($artist);
        return $artist;
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $artist = $this->artist->get($id);
        $this->artist->remove($artist);
    }
}