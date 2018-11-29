<?php

namespace frontend\widgets;

use store\entities\Artist;
use yii\base\Widget;

/**
 * Class LikeArtistsWidget
 * @package frontend\widgets
 *
 * @property Artist $artist
 * @property string $title
 */
class LikeArtistsWidget extends Widget
{
    public $artist;
    public $title = 'Похожие исполнители';

    public function run()
    {
        $likeArtists = $this->artist->likeArtists;
        if (!count($likeArtists)) {
            return '';
        }
        return $this->render('likeArtists', [
            'artists' => $likeArtists,
            'title' => $this->title,
        ]);
    }
}