<?php
namespace backend\controllers;

use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use store\entities\Arrangement;
use store\services\ArrangementService;
use store\forms\manage\arrangement\ArrangementCreateForm;
use store\forms\manage\arrangement\ArrangementUpdateForm;
use store\forms\manage\arrangement\ArrangementSearch;

/**
 * @property ArrangementService $service
 */
class ArrangementController extends Controller
{
    private $service;

    public function __construct(string $id, Module $module, ArrangementService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $arrangement = $this->findModel($id);
        return $this->render('view', [
            'arrangement' => $arrangement,
        ]);
    }

    /**
     * Displays all arrangements.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ArrangementSearch();
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
        $arrangement = $this->findModel($id);

        $form = new ArrangementUpdateForm($arrangement);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($arrangement->id, $form);
                return $this->redirect(['view', 'id' => $arrangement->id]);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'arrangement' => $arrangement,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new ArrangementCreateForm();
        $postRequest = Yii::$app->request->post();
        if ($form->load($postRequest) && $form->validate()) {
            try {
                $arrangement = $this->service->create($form);
                return $this->redirect(['view', 'id' => $arrangement->id]);
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
     * @return Arrangement
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Arrangement
    {
        if (($model = Arrangement::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
