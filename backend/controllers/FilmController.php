<?php
namespace backend\controllers;

use store\entities\Film;
use store\forms\manage\film\FilmForm;
use store\services\FilmService;
use Yii;
use store\forms\manage\film\FilmSearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Film controller
 * @property FilmService $service
 */
class FilmController extends Controller
{
    private $service;

    /**
     * FilmController constructor.
     * @param $id
     * @param Module $module
     * @param FilmService $service
     * @param array $config
     */
    public function __construct($id, Module $module, FilmService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $film = $this->findModel($id);
        return $this->render('view', [
            'film' => $film,
        ]);
    }

    /**
     * Displays all films.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new FilmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdate(int $id)
    {
        $film = $this->findModel($id);

        $form = new FilmForm($film);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($film->id, $form);
                return $this->redirect(['view', 'id' => $film->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'film' => $film,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new FilmForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $film = $this->service->create($form);
                return $this->redirect(['view', 'id' => $film->id]);
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
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['list']);
    }

    /**
     * @param int $id
     * @return Film
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Film
    {
        if (($model = Film::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
