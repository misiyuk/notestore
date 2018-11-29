<?php
namespace frontend\controllers;

use store\clientEntities\ArrangementViewed;
use store\entities\Arrangement;
use store\forms\frontend\ArrangementFilterForm;
use store\readModels\ArrangementReadModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property ArrangementReadModel $arrangement
 * @property ArrangementViewed $viewed
 */
class ArrangementController extends Controller
{
    private $arrangement;
    private $viewed;

    public function __construct($id, $module, ArrangementReadModel $arrangement, ArrangementViewed $viewed, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->arrangement = $arrangement;
        $this->viewed = $viewed;
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var Arrangement $arrangement */
        $arrangement = Arrangement::find()->where(['id' => $id])->one();
        if (!$arrangement) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->viewed->add($arrangement);
        $arrangement->updateCounters(['view_count' => 1]);
        return $this->render('view', [
            'arrangement' => $arrangement,
            'viewed' => $this->viewed,
        ]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $filterForm = new ArrangementFilterForm();
        $dataProvider = $filterForm->getAll(\Yii::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'filterForm' => $filterForm,
            'sort' => \Yii::$app->request->get('sort'),
        ]);
    }

    /**
     * Displays arrangements with genre filter.
     *
     * @return mixed
     */
    public function actionGenre()
    {
        $filterForm = new ArrangementFilterForm();
        $dataProvider = $filterForm->getAll(\Yii::$app->request->queryParams);
        return $this->render('genre', [
            'dataProvider' => $dataProvider,
            'filterForm' => $filterForm,
            'sort' => \Yii::$app->request->get('sort'),
        ]);
    }
    /**
     * Displays popular arrangements.
     *
     * @return mixed
     */
    public function actionPopular()
    {
        return $this->render('popular');
    }

    /**
     * @param int $id
     * @return Arrangement
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Arrangement
    {
        if (($model = Arrangement::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
