<?php

namespace store\repositories;

use store\entities\Artist;

class ArtistRepository
{
    /**
     * @param int $id
     * @return Artist
     */
    public function get(int $id): Artist
    {
        if (!$artist = Artist::findOne($id)) {
            throw new \DomainException('Artist is not found.');
        }
        return $artist;
    }

    /**
     * @param Artist $artist
     */
    public function save(Artist $artist): void
    {
        if (!$artist->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Artist $artist
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Artist $artist): void
    {
        if (!$artist->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
