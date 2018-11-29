<?php
namespace frontend\controllers;

use store\entities\Artist;
use store\forms\frontend\ArtistFilterForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Artist controller
 */
class ArtistController extends Controller
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $artist = $this->findModel($id);
        return $this->render('view', [
            'artist' => $artist,
        ]);
    }

    /**
     * Displays all artists.
     *
     * @return mixed
     */
    public function actionList()
    {
        $filterForm = new ArtistFilterForm();
        $dataProvider = $filterForm->filter(\Yii::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'filterForm' => $filterForm,
        ]);
    }

    /**
     * @param int $id
     * @return Artist
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Artist
    {
        if (($model = Artist::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
