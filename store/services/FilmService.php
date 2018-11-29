<?php

namespace store\services;

use store\entities\Film;
use store\forms\manage\film\FilmForm;
use store\repositories\FilmRepository;
use yii\web\User;

/**
 * @property FilmRepository $film
 * @property User $user
 */
class FilmService
{
    private $film;
    private $user;

    public function __construct(FilmRepository $film, User $user)
    {
        $this->film = $film;
        $this->user = $user;
    }

    /**
     * @param int $id
     * @param FilmForm $form
     * @throws \Exception
     */
    public function edit(int $id, FilmForm $form): void
    {
        $film = $this->film->get($id);

        $film->edit(
            $form->name,
            $this->user->id
        );

        $this->film->save($film);
    }

    /**
     * @param FilmForm $form
     * @return Film
     * @throws \Exception
     */
    public function create(FilmForm $form): Film
    {
        $film = Film::create(
            $form->name,
            $this->user->id
        );
        $this->film->save($film);
        return $film;
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $film = $this->film->get($id);
        $this->film->remove($film);
    }
}