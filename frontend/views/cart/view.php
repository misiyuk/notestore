<?php
/**
 * @var \store\clientEntities\Cart $cart
 * @var \yii\web\View $this
 */
use yii\helpers\Html;
use yii\helpers\Url;
use store\forms\frontend\CartPayForm;
use yii\caching\TagDependency;

$this->params['wrapperClasses'] = 'basket-wrapper';
?>
<?php if ($this->beginCache('cartRecommended', ['dependency' => new TagDependency(['tags' => 'cart'])])) : ?>
    <div class="workarea">
        <div class="container">
            <h1>Моя корзина</h1>
        </div>
        <div class="basket__content">
            <div class="container clearfix">
                <div class="left-side">
                    <div class="basket__head">
                        <div>
                            Товар
                        </div>
                        <div>
                            Цена
                        </div>
                    </div>
                    <?php
                    $sumPrice = 0;
                    foreach ($cart->getItems() as $saleOffer): ?>
                    <div class="basket__item">
                        <div class="left-side">
                            <div class="item__link">
                                <div class="item__img">
                                    <img src="<?= $saleOffer->offer->getOfferPreviewImage() ?>">
                                </div>
                                <a href="<?= $saleOffer->offer->url() ?>" class="item__name">
                                    <?= $saleOffer->offer->title() ?>
                                </a>
                            </div>
                            <div class="item__text">
                                <div class="item__description">
                                    <?= $saleOffer->offer->description() ?>
                                </div>
                                <div class="item-format">
                                    <?= $saleOffer->offerType->name ?>
                                </div>
                            </div>
                        </div>
                        <div class="right-side item__price">
                            <?= Yii::$app->formatter->asCurrency($saleOffer->getPrice()) ?>
                            <?php $sumPrice += $saleOffer->getPrice() ?>
                        </div>
                        <a class="remove__btn" href="#" onclick="$.ajax({
                                url: '<?= \yii\helpers\Url::to(['cart/remove', 'id' => $saleOffer->id]) ?>',
                                method: 'post',
                                success: function() {
                                    $.ajax({
                                        url: '<?= \yii\helpers\Url::to(['cart/sum']) ?>',
                                        method: 'post',
                                        success: function(response) {
                                            var result = JSON.parse(response);
                                            $('.total-price span').html(result.cartPrice);
                                            $('.total-products span').html(result.cartCount);
                                        }
                                    });
                                }
                        })">Удалить</a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="right-side">
                    <div class="payment__form">
                        <div class="form__head">
                            Оплата и получение
                        </div>
                        <div class="form__info">
                            Что бы получить выбранные ноты введите, пожалуйста, ваш e-mail. На данный e-mail мы
                            отправим ноты и все дополнительные файлы в течении 5 минут после оплаты.
                        </div>
                        <form data-ajax="true" action="<?= \yii\helpers\Url::to(['cart/pay']) ?>" method="post">
                            <div class="form__item">
                                <div class="form__item-email">
                                    <label for="e-mail">E-mail для получения <span>*</span></label>
                                    <input id="e-mail" type="text" name="<?= Html::getInputName((new CartPayForm()), 'email') ?>">
                                    <span class="order_error-message">Укажите E-mail</span>
                                </div>
                                <div class="item__info">
                                    Пожалуйста, перед отправкой внимательно
                                    проверьте введеный e-mail.
                                </div>
                                <div class="item-total">
                                    <div class="total-products">
                                        Товаров (<span><?= $this->params['cartCount'] ?></span>)
                                    </div>
                                    <div class="total-price">
                                        На сумму: <span><?= Yii::$app->formatter->asCurrency($sumPrice) ?></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="active" name="send-btn">Перейти к оплате</button>
                            <div class="order-form_send-block_item-check">
                                <input type="checkbox" id="check-order" name="<?= Html::getInputName((new CartPayForm()), 'check') ?>" value="1">
                                <label for="check-order">Нажимая на кнопку «Отправить», я даю</label>
                                <a href="#">согласие на обработку персональных данных</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php $recommended = $cart->getRecommended() ?>
        <?php if (count($recommended)): ?>
            <div class="similar__block recommended">
                <div class="container clearfix">
                    <div class="similar__block_wrap">
                        <h2>Рекомендации</h2>
                        <div class="similar__block-slider js-similar__block-slider js-slider">
                            <?php foreach ($recommended as $notePack): ?>
                            <div class="slider__item">
                                <div class="slider__item_wrap">
                                    <div class="item__link">
                                        <div class="item__img">
                                            <img src="<?= $notePack->getThumbFileUrl('preview_image', 'thumb') ?>">
                                        </div>
                                        <a href="<?= Url::to(['note-pack/view', 'id' => $notePack->id]) ?>" class="item__name">
                                            <?= $notePack->name ?>
                                        </a>
                                    </div>
                                    <div class="item__text">
                                        <div class="item-price">
                                            <?= Yii::$app->formatter->asCurrency($notePack->bestSaleOffer->price) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endCache() ?>
        <?php endif; ?>
    </div>
<?php endif; ?>