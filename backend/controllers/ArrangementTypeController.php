<?php
namespace backend\controllers;

use store\forms\manage\arrangementType\ArrangementTypeSearch;
use store\entities\ArrangementType;
use store\forms\manage\arrangementType\ArrangementTypeForm;
use store\services\ArrangementTypeService;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Film controller
 * @property ArrangementTypeService $service
 */
class ArrangementTypeController extends Controller
{
    private $service;

    /**
     * FilmController constructor.
     * @param $id
     * @param Module $module
     * @param ArrangementTypeService $service
     * @param array $config
     */
    public function __construct($id, Module $module, ArrangementTypeService $service, $config = [])
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
        $arrangementType = $this->findModel($id);
        return $this->render('view', [
            'arrangementType' => $arrangementType,
        ]);
    }

    /**
     * Displays all films.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ArrangementTypeSearch();
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
        $arrangementType = $this->findModel($id);

        $form = new ArrangementTypeForm($arrangementType);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($arrangementType->id, $form);
                return $this->redirect(['view', 'id' => $arrangementType->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new ArrangementTypeForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $arrangementType = $this->service->create($form);
                return $this->redirect(['view', 'id' => $arrangementType->id]);
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
     * @return ArrangementType
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): ArrangementType
    {
        if (($model = ArrangementType::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
