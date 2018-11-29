<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use store\forms\manage\genre\GenreSearch;
use store\forms\manage\genre\GenreForm;
use store\services\GenreService;
use yii\base\Module;
use store\entities\Genre;
use yii\web\NotFoundHttpException;

/**
 * Class GenreController
 * @package backend\controllers
 * @property GenreService $service
 */
class GenreController extends Controller
{
    private $service;

    public function __construct($id, Module $module, GenreService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Displays all genres.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new GenreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'genre' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $genre = $this->findModel($id);

        $form = new GenreForm($genre);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($genre->id, $form);
                return $this->redirect(['view', 'id' => $genre->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'genre' => $genre,
        ]);
    }

    /**
     * Create genre.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new GenreForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $genre = $this->service->create($form);
                return $this->redirect(['view', 'id' => $genre->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['list']);
    }

    /**
     * @param integer $id
     * @return Genre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Genre
    {
        if (($model = Genre::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
