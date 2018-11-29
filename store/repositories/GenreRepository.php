<?php

namespace store\repositories;

use store\entities\Genre;

class GenreRepository
{
    /**
     * @param $id
     * @return Genre
     */
    public function get($id): Genre
    {
        if (!$genre = Genre::findOne($id)) {
            throw new \DomainException('Genre is not found.');
        }
        return $genre;
    }

    /**
     * @param Genre $genre
     */
    public function save(Genre $genre): void
    {
        if (!$genre->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Genre $genre
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Genre $genre): void
    {
        if (!$genre->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
