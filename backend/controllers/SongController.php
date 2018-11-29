<?php
namespace backend\controllers;

use store\forms\manage\song\SongCreateForm;
use store\forms\manage\song\SongEditForm;
use store\services\SongService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use store\forms\manage\song\SongSearch;
use store\entities\Song;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\base\Module;

/**
 * Song controller
 *
 * @property SongService $service
 */
class SongController extends Controller
{
    private $service;

    /**
     * SongController constructor.
     * @param $id
     * @param Module $module
     * @param SongService $service
     * @param array $config
     */
    public function __construct($id, Module $module, SongService $service, $config = [])
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
        $song = $this->findModel($id);
        $arrangementTypesProvider = new ActiveDataProvider([
            'query' => $song->getArrangementTypes(),
            'pagination' => false,
        ]);
        $genresProvider = new ActiveDataProvider([
            'query' => $song->getGenres(),
            'pagination' => false,
        ]);
        $artistsProvider = new ActiveDataProvider([
            'query' => $song->getArtists(),
            'pagination' => false,
        ]);
        $filmsProvider = new ActiveDataProvider([
            'query' => $song->getFilms(),
            'pagination' => false,
        ]);
        return $this->render('view', [
            'song' => $song,
            'arrangementTypesProvider' => $arrangementTypesProvider,
            'genresProvider' => $genresProvider,
            'artistsProvider' => $artistsProvider,
            'filmsProvider' => $filmsProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionList(): string
    {
        $searchModel = new SongSearch();
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
        $song = $this->findModel($id);

        $form = new SongEditForm($song);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($song->id, $form);
                return $this->redirect(['view', 'id' => $song->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'song' => $song,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $form = new SongCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $song = $this->service->create($form);
                return $this->redirect(['view', 'id' => $song->id]);
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
     * @param int $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id): \yii\web\Response
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
     * @return Song
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Song
    {
        if (($model = Song::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
