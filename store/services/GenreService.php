<?php

namespace store\services;

use store\entities\Genre;
use store\forms\manage\genre\GenreForm;
use store\repositories\GenreRepository;

/**
 * Class GenreService
 * @package store\services
 * @property GenreRepository $genre
 */
class GenreService
{
    private $genre;

    public function __construct(GenreRepository $genre)
    {
        $this->genre = $genre;
    }

    public function create(GenreForm $form): Genre
    {
        $genre = Genre::create($form->name);
        $this->genre->save($genre);
        return $genre;
    }

    public function edit($id, GenreForm $form): void
    {
        $genre = $this->genre->get($id);
        $genre->edit($form->name);
        $this->genre->save($genre);
    }

    /**
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $genre = $this->genre->get($id);
        $this->genre->remove($genre);
    }
}