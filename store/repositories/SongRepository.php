<?php

namespace store\repositories;

use store\entities\Song;

class SongRepository
{
    public function get($id): Song
    {
        if (!$song = Song::findOne($id)) {
            throw new \DomainException('Song is not found.');
        }
        return $song;
    }

    public function save(Song $song): void
    {
        if (!$song->save()) {
            print_r($song->errors);
            throw new \RuntimeException('Song saving error.');
        }
    }

    /**
     * @param Song $song
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Song $song): void
    {
        if (!$song->delete()) {
            throw new \RuntimeException('Removing song error.');
        }
    }
}