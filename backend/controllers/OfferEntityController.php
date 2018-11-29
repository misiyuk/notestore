<?php
namespace backend\controllers;

use store\entities\OfferEntity;
use store\forms\manage\offerEntity\OfferEntityForm;
use store\services\OfferEntityService;
use Yii;
use store\forms\manage\offerEntity\OfferEntitySearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property OfferEntityService $service
 */
class OfferEntityController extends Controller
{
    private $service;

    /**
     * FilmController constructor.
     * @param $id
     * @param Module $module
     * @param OfferEntityService $service
     * @param array $config
     */
    public function __construct($id, Module $module, OfferEntityService $service, $config = [])
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
        $offerEntity = $this->findModel($id);
        return $this->render('view', [
            'offerEntity' => $offerEntity,
        ]);
    }

    /**
     * Displays all films.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new OfferEntitySearch();
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
        $offerEntity = $this->findModel($id);

        $form = new OfferEntityForm($offerEntity);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($offerEntity->id, $form);
                return $this->redirect(['view', 'id' => $offerEntity->id]);
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
        $form = new OfferEntityForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $offerEntity = $this->service->create($form);
                return $this->redirect(['view', 'id' => $offerEntity->id]);
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
     * @return OfferEntity
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): OfferEntity
    {
        if (($model = OfferEntity::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
