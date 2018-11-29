<?php
namespace frontend\controllers;

use store\forms\frontend\OrderForm;
use store\services\OrderService;
use yii\base\Module;
use yii\web\Controller;

/**
 * Offer controller
 *
 * @property OrderService $service
 */
class OrderController extends Controller
{
    private $service;

    public function __construct(string $id, Module $module, OrderService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $filterForm = new OrderForm();
        if ($filterForm->load(\Yii::$app->request->queryParams) && $filterForm->validate()) {
            try {
                $this->service->create($filterForm);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'form' => $filterForm,
        ]);
    }

    public function actionList()
    {
        $user = \store\entities\User::findOne(['id' => \Yii::$app->user->id]);
        return $this->render('list', [
            'saleOfferOrders' => $user->saleOfferOrders ?: [],
        ]);
    }
}
