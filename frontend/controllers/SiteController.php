<?php
namespace frontend\controllers;

use yii\web\Controller;
use store\readModels\ArrangementReadModel;
use store\readModels\NotePackReadModel;

/**
 * Class SiteController
 * @package frontend\controllers
 *
 * @property ArrangementReadModel $arrangement
 * @property NotePackReadModel $notePack
 */
class SiteController extends Controller
{
    private $arrangement;
    private $notePack;
    public function __construct(
        $id,
        $module,
        ArrangementReadModel $arrangement,
        NotePackReadModel $notePack,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->arrangement = $arrangement;
        $this->notePack = $notePack;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'notePackReadModel' => $this->notePack,
            'arrangementReadModel' => $this->arrangement,
        ]);
    }
}
