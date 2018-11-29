<?php

namespace store\forms\frontend;

use store\entities\Arrangement;
use store\entities\ArrangementType;
use store\entities\Artist;
use store\entities\Song;
use store\entities\SongArtistAssignments;
use yii\base\Model;
use store\entities\TitleSearch;
use yii\db\Expression;

/**
 * Class TitleSearchForm
 * @package store\forms\frontend
 *
 * @property string $query
 */
class TitleSearchForm extends Model
{
    public $query;

    public function rules(): array
    {
        return [
            ['query', 'required'],
            ['query', 'string', 'max' => 255],
        ];
    }

    /**
     * @param array $params
     * @return TitleSearch[]
     */
    public function search(array $params): array
    {
        if (!$this->load($params) && !$this->validate()) {
            return [];
        }
        $artists = $this->searchArtists();
        $arrangements = $this->searchArrangements();
        return $artists + $arrangements;
    }

    /**
     * @return Artist[]
     */
    private function searchArtists(): array
    {
        return Artist::find()
            ->where(['like', new Expression('UPPER(name)'), mb_strtoupper($this->query)])
            ->limit(10)
            ->all();
    }

    /**
     * @return Arrangement[]
     */
    private function searchArrangements(): array
    {
        /**
         * CONCAT_WS("-", "SQL", "Tutorial", "is", "fun!") AS ConcatenatedStrin
         */
        return Arrangement::find()
            ->alias('arrangement')
            ->leftJoin(Song::tableName() . ' as song', 'song.id = arrangement.song_id')
            ->leftJoin(ArrangementType::tableName() . ' as type', 'type.id = arrangement.arrangement_type_id')
            ->leftJoin(SongArtistAssignments::tableName() . ' as song_artist', 'song_artist.song_id = song.id')
            ->leftJoin(Artist::tableName() . ' as artist', 'artist.id = song_artist.artist_id')
            ->where(['like', new Expression('UPPER(' . new Expression('CONCAT_WS(\' - \', song.name, artist.name, type.name)') . ')'), mb_strtoupper($this->query)])
            ->limit(10)
            ->all();
    }
}