<?php
/**
 * @var \yii\web\View $this
 * @var \store\entities\NotePack|\yiidreamteam\upload\ImageUploadBehavior $notePack
 * @var \store\entities\NotePack|\yiidreamteam\upload\ImageUploadBehavior $likeNotePack
 * @var \store\entities\NotePack|\yiidreamteam\upload\ImageUploadBehavior $notePackViewed
 * @var \store\clientEntities\NotePackViewed $viewed
 */
use store\forms\frontend\CartForm;
use yii\helpers\Html;
use yii\helpers\Url;
use store\forms\frontend\ArrangementFilterForm;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Нотные наборы', 'url' => ['note-pack/list']];
$this->params['breadcrumbs'][] = $notePack->name;
?>
<div class="workarea">
    <div class="container clearfix">
        <h1>Нотный набор - <?= $notePack->name ?></h1>
    </div>
    <div class="product__block">
        <div class="container clearfix">
            <div class="product__wrap">
                <div class="product__img">
                    <img src="<?= $notePack->getThumbFileUrl('detail_image', 'detail') ?>">
                </div>
                <div class="product__description">
                    <div class="warning-message">
                        <strong>Внимание!</strong> Указанные скидки действительны только в составе данного
                        сборника.
                    </div>
                    <div class="info">
                        <p>Жанр: <?php
                            foreach ($notePack->genres as $key => $genre):
                                ?><?= $key ? ', ' : '' ?><a href="<?= \yii\helpers\Url::to(['arrangement/genre', Html::getInputName((new ArrangementFilterForm()), 'genre[]') => $genre->id]) ?>"><?= $genre->name ?></a><?php
                            endforeach;
                            ?></p>
                        <p>Форматы: <?= reset($notePack->arrangements)->formats->name ?></p>
                    </div>
                    <div class="description">
                        <?= $notePack->description ?>
                    </div>
                    <div class="warning-message__mobile">
                        <strong>Внимание!</strong> Указанные скидки действительны только в составе данного
                        сборника.
                    </div>
                </div>
                <div class="product__form">
                    <div class="product__form_wrap">
                        <div class="form__head">Доступные форматы</div>
                        <div class="form__info">Ноты высылаются на e-mail указанный Вами при оформлении заказ.
                        </div>
                        <form id="addCartItem">
                            <?php
                            $sumDiscount = 0;
                            foreach ($notePack->saleOffers as $i => $saleOffer): ?>
                            <div class="form__item">
                                <div class="item__button"><input id="format-<?= $i ?>" type="radio"
                                                                 value="<?= $saleOffer->id ?>"
                                                                 name="<?= Html::getInputName(new CartForm(), 'saleOfferId') ?>"
                                                                 hidden
                                                                 <?= !$i ? 'checked' : '' ?>
                                    ><label for="format-<?= $i ?>"><?= $saleOffer->offerType->name ?></label></div>
                                <div class="item__price">
                                    <div class="old-price"><?= Yii::$app->formatter->asCurrency($saleOffer->oldPrice) ?></div>
                                    <div><?= Yii::$app->formatter->asCurrency($saleOffer->newPrice) ?></div>
                                </div>
                            </div>
                            <?php $sumDiscount += $saleOffer->oldPrice - $saleOffer->newPrice ?>
                            <?php endforeach; ?>
                        </form>
                        <a class="add-to-basket__btn js-add-to-basket__btn<?= $notePack->inCart() ? ' active' : '' ?>"
                           href="<?= Url::to(['cart/view']) ?>"><span>Добавить в корзину</span><span>Перейти в корзину</span></a>
                        <div class="price-profit">Ваша выгода: <?= Yii::$app->formatter->asCurrency($sumDiscount) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="collection-content">
        <div class="container clearfix">
            <h2>Содержание сборника</h2>
            <div class="collection__head">
                <div class="left-side">Товар</div>
                <div class="right-side">
                    <div>Цена без скидки</div>
                    <div>Скидка</div>
                    <div>Цена со скидкой</div>
                </div>
            </div>
            <?php foreach ($notePack->arrangements as $arrangement): ?>
                <div class="collection__item">
                    <div class="left-side">
                        <div class="item__link">
                            <div class="item__img">
                                <img src="<?= $notePack->getThumbFileUrl('preview_image', 'thumb') ?>">
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['arrangement/view', 'id' => $arrangement->id]) ?>" class="item__name">
                                <?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?>, <?= $arrangement->year ?>
                            </a>
                        </div>
                        <div class="item__text">
                            <div class="item__description">
                                <?= $arrangement->arrangementType->name ?>
                            </div>
                            <div class="item-format">
                                <?= $arrangement->formats->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="right-side__item price-wt-disc">
                            <div class="item__head">Цена без скидки</div>
                            <div class="item__text"><?= Yii::$app->formatter->asCurrency($arrangement->mainSaleOffer->price) ?></div>
                        </div>
                        <div class="right-side__item discount">
                            <div class="item__head">Скидка</div>
                            <div class="item__text"><?= $notePack->discount ?> %</div>
                        </div>
                        <div class="right-side__item price-wh-disc">
                            <div class="item__head">Цена со скидкой</div>
                            <div class="item__text"><?= Yii::$app->formatter->asCurrency($arrangement->mainSaleOffer->price - ($arrangement->mainSaleOffer->price * ($notePack->discount / 100))) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (count($notePack->likeNotePacks)): ?>
    <div class="similar__block pack">
        <div class="container clearfix">
            <div class="similar__block_wrap">
                <h2>Похожие сборники</h2>
                <div class="similar__block-slider js-similar__block-slider js-slider">
                    <?php foreach ($notePack->likeNotePacks as $likeNotePack): ?>
                        <div class="slider__item">
                            <div class="slider__item_wrap">
                                <div class="item__link">
                                    <div class="item__img">
                                        <img src="<?= $likeNotePack->getThumbFileUrl('preview_image', 'thumb') ?>">
                                    </div>
                                    <a href="<?= \yii\helpers\Url::to(['note-pack/view', 'id' => $notePack->id]) ?>" class="item__name">
                                        <?= $likeNotePack->name ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($viewed->count()): ?>
    <div class="similar__block recently">
        <div class="container clearfix">
            <div class="similar__block_wrap">
                <h2>Недавно просмотренные</h2>
                <div class="similar__block-slider js-similar__block-slider js-slider">
                    <?php foreach ($viewed->getItems() as $notePackViewed): ?>
                    <div class="slider__item">
                        <div class="slider__item_wrap">
                            <div class="item__link">
                                <div class="item__img">
                                    <img src="<?= $notePackViewed->getThumbFileUrl('preview_image', 'thumb') ?>">
                                </div>
                                <a href="<?= Url::to(['note-pack/view', 'id' => $notePackViewed->id]) ?>" class="item__name">
                                    <?= $notePackViewed->name ?>
                                </a>
                            </div>
                            <div class="item__text">
                                <div class="item__description"></div>
                                <div class="item-price">
                                    <?= Yii::$app->formatter->asCurrency($notePackViewed->mainSaleOffer->price) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>