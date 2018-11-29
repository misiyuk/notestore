<?php
namespace frontend\controllers;

use store\clientEntities\NotePackViewed;
use store\entities\NotePack;
use store\forms\frontend\NotePackFilterForm;
use store\readModels\NotePackReadModel;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property NotePackReadModel $notePack
 * @property NotePackViewed $viewed
 */
class NotePackController extends Controller
{
    private $notePack;
    private $viewed;
    public function __construct(string $id, Module $module, NotePackReadModel $notePack, NotePackViewed $viewed, array $config = [])
    {
        $this->notePack = $notePack;
        $this->viewed = $viewed;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var NotePack $notePack */
        $notePack = NotePack::find()
            ->with([
                'arrangements.mainSaleOffer',
                'arrangements.formats',
                'arrangements.saleOffers.offerType',
            ])
            ->where(['id' => $id])
            ->one();
        if (!$notePack) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->viewed->add($notePack);
        $notePack->updateCounters(['view_count' => 1]);
        return $this->render('view', [
            'notePack' => $notePack,
            'viewed' => $this->viewed,
        ]);
    }

    /**
     * Displays all note-packs.
     *
     * @return mixed
     */
    public function actionList()
    {
        $filterForm = new NotePackFilterForm();
        $dataProvider = $filterForm->getAll(\Yii::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'filterForm' => $filterForm,
            'sort' => \Yii::$app->request->get('sort'),
        ]);
    }

    /**
     * @param int $id
     * @return NotePack
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): NotePack
    {
        if (($model = NotePack::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
