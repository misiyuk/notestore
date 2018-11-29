<?php
namespace backend\controllers;

use store\entities\NotePack;
use store\forms\manage\notePack\NotePackCreateForm;
use store\forms\manage\notePack\NotePackUpdateForm;
use store\services\NotePackService;
use Yii;
use store\forms\manage\notePack\NotePackSearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property NotePackService $service
 */
class NotePackController extends Controller
{
    private $service;

    /**
     * NotePackController constructor.
     * @param $id
     * @param Module $module
     * @param NotePackService $service
     * @param array $config
     */
    public function __construct($id, Module $module, NotePackService $service, $config = [])
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
    public function actionView(int $id)
    {
        $notePack = $this->findModel($id);
        return $this->render('view', [
            'notePack' => $notePack,
        ]);
    }

    /**
     * Displays all note packs.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new NotePackSearch();
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
     */
    public function actionUpdate(int $id)
    {
        $notePack = $this->findModel($id);

        $form = new NotePackUpdateForm($notePack);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($notePack->id, $form);
                return $this->redirect(['view', 'id' => $notePack->id]);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'notePack' => $notePack,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new NotePackCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $notePack = $this->service->create($form);
                return $this->redirect(['view', 'id' => $notePack->id]);
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
    public function actionDelete(int $id)
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
