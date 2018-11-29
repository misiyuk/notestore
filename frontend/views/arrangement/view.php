<?php
/**
 * @var \store\entities\Arrangement|\yiidreamteam\upload\ImageUploadBehavior $arrangement
 * @var \yii\web\View $this
 * @var \store\entities\Artist $mainArtist
 * @var \store\entities\Artist|\yiidreamteam\upload\ImageUploadBehavior $artist
 * @var \store\clientEntities\ArrangementViewed $viewed
 */

use frontend\assets;
use yii\helpers\Html;
use yii\helpers\Url;
use store\forms\frontend\ArrangementFilterForm;
use store\forms\frontend\CartForm;
use store\helpers\PriceHelper;
assets\AppAsset::register($this);
assets\FancyBoxAsset::register($this);
assets\AudioPlayerAsset::register($this);

$this->title = $arrangement->song->artistsString . ' - ' .
    $arrangement->song->name . ' - ' .
    $arrangement->arrangementType->name;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Аранжировки', 'url' => ['arrangement/list']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wrapperClasses'] = 'note-artist-wrapper';
$mainArtist = reset($arrangement->song->artists);
?>
<div class="workarea note-card_workarea">
    <div class="container clearfix">
        <h1><?= $this->title ?></h1>
    </div>
    <div class="note_card-description">
        <div class="container">
            <div class="note_card-description-wrap">
                <div class="note_card-description-img">
                    <div class="note_card-description-img-wrap">
                        <a href="<?= $arrangement->getThumbFileUrl('detail_image', 'thumb') ?>" data-fancybox rel="main-slaider">
                            <img src="<?= $arrangement->getImageFileUrl('detail_image') ?>">
                            <img src="/img/zoom.png" alt="" class="note_card-description-zoom">
                        </a>
                    </div>
                </div>
                <div class="note_card-description-player">
                    <div class="note_card-description-info">
                        <p>Артист<?= count($arrangement->song->artists) > 1 ? 'ы' : '' ?>: <?php
                            foreach ($arrangement->song->artists as $artist):
                                ?><a
                                href="<?= Url::to(['artist/view', 'id' => $artist->id]) ?>"><?= $artist->name ?></a> <?php
                            endforeach;
                            ?></p>
                        <p>Произведение: <?= $arrangement->song->name ?></p>
                        <p>Другие аранжировки:
                            <?php foreach ($arrangement->song->arrangements as $i => $arrangementForType): ?>
                                <?php if ($arrangementForType->id == $arrangement->id) continue; ?>
                                <a href="<?= Url::to(['arrangement/view', 'id' => $arrangementForType->id]) ?>"><?= $arrangementForType->arrangementType->name ?><?= $i + 1 != count($arrangement->song->arrangements) ? ',' : '' ?> </a>
                            <?php endforeach; ?>
                        </p>
                        <p>Жанр: <?php foreach ($arrangement->song->genres as $i => $genre): ?>
                                <a href="<?= Url::to(['arrangement/genre', Html::getInputName(new ArrangementFilterForm(), 'genre') => [$genre->id]]) ?>"><?= $genre->name ?><?= $i + 1 != count($arrangement->song->genres) ? ',' : '' ?> </a>
                            <?php endforeach; ?></p>
                        <p>Форматы: <?= $arrangement->formats->name ?></p>
                    </div>
                    <div class="note_card-description-links">
                        <a href="#songtext-block">Текст песни</a>
                        <a href="#video-block">Видео</a>
                    </div>
                    <div class="note_card-description-player-wrap">
                        <audio preload="auto" controls>
                            <source src="<?= $arrangement->song->getUploadedFileUrl('audio') ?>"/>
                        </audio>
                    </div>
                </div>
                <div class="product__form">
                    <div class="product__form_wrap">
                        <div class="form__head">Доступные форматы</div>
                        <div class="form__info">Ноты высылаются на e-mail указанный Вами при оформлении заказ.
                        </div>
                        <form id="addCartItem">
                            <?php foreach ($arrangement->saleOffers as $i => $saleOffer): ?>
                                <div class="form__item">
                                    <div class="item__button"><input id="format-<?= $i ?>" type="radio"
                                                                     value="<?= $saleOffer->id ?>"
                                                                     name="<?= Html::getInputName(new CartForm(), 'saleOfferId') ?>"
                                                                     <?= !$i ? 'checked' : '' ?>
                                        ><label
                                                for="format-<?= $i ?>"><?= $saleOffer->offerType->name ?></label>
                                    </div>
                                    <div class="item__price">
                                        <div><?= PriceHelper::asCurrency($saleOffer->price) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </form>
                        <a class="add-to-basket__btn js-add-to-basket__btn<?= $arrangement->inCart() ? ' active' : '' ?>" href="<?= Url::to(['cart/view']) ?>">
                            <span>Добавить в корзину</span>
                            <span>Перейти в корзину</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container clearfix">
        <?= \frontend\widgets\OtherArrangementsWidget::widget([
            'artist' => $mainArtist
        ]) ?>
    </div>
    <a class="show-more__btn" href="#">
        <div>Показать еще</div>
    </a>
    <div class="note_card-video" id="video-block">
        <div class="container">
            <div class="note_card-video-wrap">
                <iframe width="962" height="523"
                        src="https://www.youtube.com/embed/<?= $arrangement->song->video ?>?rel=0&amp;controls=0&amp;showinfo=0"
                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="note_card_song-text" id="songtext-block">
        <div class="container">
            <div class="note_card_song-text-wrap">
                <h3><?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?></h3>
                <?= $arrangement->song->text ?>
            </div>
        </div>
    </div>
    <?php if (count($mainArtist->likeArtists)): ?>
    <div class="similar__block">
        <div class="container clearfix">
            <div class="similar__block_wrap">
                <h2>Похожие исполнители</h2>
                <div class="similar__block-slider js-similar__block-slider js-slider">
                    <?php foreach ($mainArtist->likeArtists as $artist): ?>
                        <div class="slider__item">
                            <div class="slider__item_wrap">
                                <div class="item__link">
                                    <div class="item__img">
                                        <img src="<?= $artist->getThumbFileUrl('preview_image', 'thumb') ?>">
                                    </div>
                                    <a href="<?= Url::to(['artist/view', 'id' => $artist->id]) ?>" class="item__name">
                                        <?= $artist->name ?>
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
                    <?php /** @var \store\entities\Arrangement|\yiidreamteam\upload\ImageUploadBehavior $arrangementViewed */ ?>
                    <?php foreach ($viewed->getItems() as $arrangementViewed): ?>
                    <div class="slider__item">
                        <div class="slider__item_wrap">
                            <div class="item__link">
                                <div class="item__img">
                                    <img src="<?= $arrangementViewed->getThumbFileUrl('preview_image', 'arrangement_list') ?>">
                                </div>
                                <a href="<?= Url::to(['arrangement/view', 'id' => $arrangementViewed->id]) ?>" class="item__name">
                                    <?= $arrangementViewed->song->artistsString ?> - <?= $arrangementViewed->song->name ?>,
                                    <?= $arrangementViewed->year ?>
                                </a>
                            </div>
                            <div class="item__text">
                                <div class="item__description">
                                    <?= $arrangementViewed->arrangementType->name ?>
                                </div>
                                <div class="item-price">
                                    <?= PriceHelper::asCurrency($arrangementViewed->mainSaleOffer->price) ?>
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
