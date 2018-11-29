<?php
namespace frontend\controllers;

use store\clientEntities\Cart;
use store\forms\frontend\CartForm;
use store\forms\frontend\CartPayForm;
use store\jobs\SendEmailJob;
use store\services\CartService;
use store\services\SaleOfferOrderService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\queue\redis\Queue;
use yii\web\Controller;

/**
 * Cart controller
 * @property CartService $service
 * @property SaleOfferOrderService $saleOfferOrder
 * @property Cart $cart
 */
class CartController extends Controller
{

    private $service;
    private $cart;
    private $saleOfferOrder;
    public $enableCsrfValidation = false;

    public function __construct(
        string $id,
        Module $module,
        Cart $cart,
        CartService $service,
        SaleOfferOrderService $saleOfferOrder,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->saleOfferOrder = $saleOfferOrder;
        $this->service = $service;
        $this->cart = $cart;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                    'remove' => ['POST'],
                    'count' => ['POST'],
                    'sum' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        $form = new CartForm();
        $postRequest = \Yii::$app->request->post();
        $type = 'ERROR';
        if ($form->load($postRequest) && $form->validate()) {
            try {
                $this->service->add($form);
                $type = 'OK';
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                $type = 'ERROR';
            }
        } else {
            \Yii::$app->errorHandler->logException(new \DomainException('Don\'t add item to cart. Form is not valid'));
        }
        return $this->renderAjax('add', [
            'type' => $type,
            'message' => $type == 'ERROR' ? 'Произошла ошибка при добавлении' : '',
        ]);
    }

    /**
     * @param int $id
     */
    public function actionRemove($id): void
    {
        $this->service->remove($id);
    }

    public function actionSum()
    {
        return $this->renderAjax('ajax/sum');
    }
    /**
     * Displays cart.
     *
     * @return mixed
     */
    public function actionView()
    {
        return $this->render('view', [
            'cart' => $this->cart,
        ]);
    }

    /**
     * Displays "thank you" page.
     *
     * @return mixed
     */
    public function actionThank()
    {
        return $this->render('thank');
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionPay()
    {
        $form = new CartPayForm();
        $postRequest = \Yii::$app->request->post();
        if ($form->load($postRequest) && $form->validate()) {
            /** @var Queue $queue */
            $queue = \Yii::$app->queue;
            $saleOffers = $this->cart->getItems();
            $queue->push(new SendEmailJob($form, $saleOffers));
            $this->saleOfferOrder->create($form);
            $this->cart->clearItems();
            return $this->redirect(['cart/thank']);
        }
        return $this->redirect(['cart/error']);
    }

    /**
     * Displays cart error page.
     *
     * @return mixed
     */
    public function actionError()
    {
        return $this->render('error');
    }

    public function actionCount()
    {
        return $this->renderAjax('ajax/count');
    }
}
