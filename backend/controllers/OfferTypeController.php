<?php
namespace backend\controllers;

use store\entities\OfferType;
use store\forms\manage\offerType\OfferTypeForm;
use store\services\OfferTypeService;
use Yii;
use store\forms\manage\offerType\OfferTypeSearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Offer type controller
 * @property OfferTypeService $service
 */
class OfferTypeController extends Controller
{
    private $service;

    /**
     * FilmController constructor.
     * @param $id
     * @param Module $module
     * @param OfferTypeService $service
     * @param array $config
     */
    public function __construct($id, Module $module, OfferTypeService $service, $config = [])
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
        $offerType = $this->findModel($id);
        return $this->render('view', [
            'offerType' => $offerType,
        ]);
    }

    /**
     * Displays all films.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new OfferTypeSearch();
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
        $offerType = $this->findModel($id);

        $form = new OfferTypeForm($offerType);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($offerType->id, $form);
                return $this->redirect(['view', 'id' => $offerType->id]);
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
        $form = new OfferTypeForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $offerType = $this->service->create($form);
                return $this->redirect(['view', 'id' => $offerType->id]);
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
     * @return OfferType
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): OfferType
    {
        if (($model = OfferType::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
