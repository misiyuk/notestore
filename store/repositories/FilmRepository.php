<?php

namespace store\repositories;

use store\entities\Film;

class FilmRepository
{
    /**
     * @param int $id
     * @return Film
     */
    public function get(int $id): Film
    {
        if (!$film = Film::findOne($id)) {
            throw new \DomainException('Film is not found.');
        }
        return $film;
    }

    /**
     * @param Film $film
     */
    public function save(Film $film): void
    {
        if (!$film->save()) {
            throw new \RuntimeException('Film saving error.');
        }
    }

    /**
     * @param Film $film
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Film $film): void
    {
        if (!$film->delete()) {
            throw new \RuntimeException('Removing film error.');
        }
    }
}