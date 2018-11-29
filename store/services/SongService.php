<?php

namespace store\services;

use yii\web\User;
use store\forms\manage\song\SongCreateForm;
use store\forms\manage\song\SongEditForm;
use store\repositories\GenreRepository;
use store\repositories\ArtistRepository;
use store\repositories\SongRepository;
use store\repositories\FilmRepository;
use store\entities\Song;

/**
 * @property SongRepository $song
 * @property GenreRepository $genre
 * @property ArtistRepository $artist
 * @property FilmRepository $film
 * @property User $user
 * @property TransactionManager $transaction
 */
class SongService
{
    private $song;
    private $genre;
    private $artist;
    private $user;
    private $transaction;

    public function __construct(
        SongRepository $song,
        GenreRepository $genre,
        ArtistRepository $artist,
        FilmRepository $film,
        User $user,
        TransactionManager $transaction
    )
    {
        $this->song = $song;
        $this->genre = $genre;
        $this->film = $film;
        $this->artist = $artist;
        $this->user = $user;
        $this->transaction = $transaction;
    }

    public function create(SongCreateForm $form): Song
    {
        $song = Song::create(
            $form->name,
            $form->text,
            $form->video,
            $form->audio,
            $this->user->id
        );

        foreach ($form->genres->ids as $genreId) {
            $genre = $this->genre->get($genreId);
            $song->assignGenre($genre->id);
        }

        foreach ($form->artists->ids as $artistId) {
            $artist = $this->artist->get($artistId);
            $song->assignArtist($artist->id);
        }

        foreach ($form->films->ids as $filmId) {
            $film = $this->film->get($filmId);
            $song->assignFilm($film->id);
        }
        $this->song->save($song);

        return $song;
    }

    /**
     * @param int $id
     * @param SongEditForm $form
     * @throws \Exception
     */
    public function edit(int $id, SongEditForm $form): void
    {
        $song = $this->song->get($id);
        $song->edit(
            $form->name,
            $form->text,
            $form->video,
            $form->audio,
            $this->user->id
        );

        $song->revokeArtists();
        $song->revokeGenres();
        $song->revokeFilms();
        $this->transaction->wrap(function() use ($song, $form) {
            $this->song->save($song);
            foreach ($form->genres->ids as $genreId) {
                $genre = $this->genre->get($genreId);
                $song->assignGenre($genre->id);
            }
            foreach ($form->artists->ids as $artistId) {
                $artist = $this->artist->get($artistId);
                $song->assignArtist($artist->id);
            }
            foreach ($form->films->ids as $filmId) {
                $film = $this->film->get($filmId);
                $song->assignFilm($film->id);
            }
            $this->song->save($song);
        });
    }

    /**
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $song = $this->song->get($id);
        $this->song->remove($song);
    }
}
