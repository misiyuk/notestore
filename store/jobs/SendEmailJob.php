<?php

namespace store\jobs;

use store\entities\SaleOffer;
use store\forms\frontend\CartPayForm;
use yii\queue\Job;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * Class SendEmailJob
 * @package store\jobs
 *
 * @property CartPayForm $form
 * @property SaleOffer[] $saleOffers
 */
class SendEmailJob implements Job
{
    private $form;
    private $saleOffers;

    public function __construct(CartPayForm $form, array $saleOffers)
    {
        $this->form = $form;
        $this->saleOffers = $saleOffers;
    }

    public function execute($queue)
    {
        $message = \Yii::$app->mailer->compose('sale-html')
            ->setFrom('from@domain.com')
            ->setTo($this->form->email)
            ->setSubject('theme');
        foreach ($this->saleOffers as $saleOffer) {
            /** @var FileUploadBehavior $saleOffer */
            $message->attach($saleOffer->getUploadedFilePath('file'));
        }
        $message->send();
    }
}
