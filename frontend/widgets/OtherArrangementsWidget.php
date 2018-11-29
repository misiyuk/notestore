<?php

namespace frontend\widgets;

use store\entities\Artist;
use store\repositories\ArrangementTypeRepository;
use yii\base\Widget;

/**
 * Class OtherArrangementsWidget
 * @package frontend\widgets
 * @property Artist $artist
 * @property string $title
 * @property ArrangementTypeRepository $arrangementTypeRepository
 */
class OtherArrangementsWidget extends Widget
{
    public $artist;
    public $title = 'Другие ноты исполнителя';

    private $arrangementTypeRepository;

    public function __construct(ArrangementTypeRepository $arrangementTypeRepository, array $config = [])
    {
        parent::__construct($config);
        $this->arrangementTypeRepository = $arrangementTypeRepository;
    }

    public function run()
    {
        $arrangementTypeId = \Yii::$app->request->get(self::class)['arrangementTypeId'];
        if ($arrangementTypeId > 0) {
            $arrangementType = $this->arrangementTypeRepository->get($arrangementTypeId);
        } else {
            $arrangementType = null;
        }
        $arrangements = $this->artist->getArrangements($arrangementType);
        if (!count($arrangements) && $arrangementType === null) {
            return '';
        }
        return $this->render('otherArrangements', [
            'arrangementTypeId' => $arrangementTypeId,
            'arrangements' => $arrangements,
            'arrangementTypes' => $this->artist->arrangementTypes,
            'title' => $this->title,
        ]);
    }
}