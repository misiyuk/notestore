<?php
namespace backend\controllers;

use store\entities\Formats;
use store\forms\manage\formats\FormatsForm;
use store\services\FormatsService;
use Yii;
use store\forms\manage\formats\FormatsSearch;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property FormatsService $service
 */
class FormatsController extends Controller
{
    private $service;

    /**
     * FormatsController constructor.
     * @param $id
     * @param Module $module
     * @param FormatsService $service
     * @param array $config
     */
    public function __construct($id, Module $module, FormatsService $service, $config = [])
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
        $formats = $this->findModel($id);
        return $this->render('view', [
            'formats' => $formats,
        ]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $searchModel = new FormatsSearch();
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
        $formats = $this->findModel($id);

        $form = new FormatsForm($formats);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($formats->id, $form);
                return $this->redirect(['view', 'id' => $formats->id]);
            } catch (\Exception $e) {
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
        $form = new FormatsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $formats = $this->service->create($form);
                return $this->redirect(['view', 'id' => $formats->id]);
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
     * @return Formats
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Formats
    {
        if (($model = Formats::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
