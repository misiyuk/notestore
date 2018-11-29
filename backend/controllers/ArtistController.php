<?php
namespace backend\controllers;

use store\entities\Artist;
use store\forms\manage\artist\ArtistForm;
use store\services\ArtistService;
use Yii;
use store\forms\manage\artist\ArtistSearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Artist controller
 * @property ArtistService $service
 */
class ArtistController extends Controller
{
    private $service;

    /**
     * FilmController constructor.
     * @param $id
     * @param Module $module
     * @param ArtistService $service
     * @param array $config
     */
    public function __construct($id, Module $module, ArtistService $service, $config = [])
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
        $artist = $this->findModel($id);
        return $this->render('view', [
            'artist' => $artist,
        ]);
    }

    /**
     * Displays all films.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ArtistSearch();
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
        $artist = $this->findModel($id);

        $form = new ArtistForm($artist);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($artist->id, $form);
                return $this->redirect(['view', 'id' => $artist->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'artist' => $artist,
            'model' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $form = new ArtistForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $artist = $this->service->create($form);
                return $this->redirect(['view', 'id' => $artist->id]);
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
