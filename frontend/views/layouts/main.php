<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="full-page-wrapper <?= isset($this->params['wrapperClasses']) ? $this->params['wrapperClasses'] : '' ?>">
    <div class="mobile_menu-block">
        <div class="mobile_menu-head clearfix">
            <div class="mobile_menu-logo">
                <img src="/img/m-logo.png" alt="">
            </div>
            <div class="mobile_menu-close">
                <img src="/img/m-close.png" alt="">
            </div>
        </div>
        <div class="header_middle-info_sign-in">
            <a href="#">Вход</a>
            <a href="#">Регистрация</a>
        </div>
        <div class="mobile_menu-linklist">
            <ul>
                <li><a href="<?= Url::to(['artist/list']) ?>">Музыканты</a></li>
                <li><a href="<?= Url::to(['arrangement/list']) ?>">Аранжировки</a></li>
                <li><a href="<?= Url::to(['arrangement/genre']) ?>">Жанры</a></li>
                <li><a href="<?= Url::to(['note-pack/list']) ?>">Нотные наборы</a></li>
                <li><a href="<?= Url::to(['order/index']) ?>">Заказать ноты</a></li>
                <li><a href="<?= Url::to(['site/index']) ?>">Магазин музыкальных  инструментов</a></li>
            </ul>
        </div>
        <div class="mobile_menu-country">
            <div class="mobile_menu-country_wrap clearfix">
                <div class="mobile_menu-country_text">
                    <span>Страна/Валюта</span>
                </div>
                <div class="header_middle-info_change-language_mobile">
                    <div class="header_middle-info_change-language_flag">
                        <img src="/img/flag-rus.png" alt="">
                    </div>
                    <div class="header_middle-info_change-language_currency">
                        <span>₽</span>
                    </div>
                </div>
            </div>
            <div class="header_middle-info_change-language_hidden">
                <p>Язык</p>
                <ul>
                    <li class="header_middle-info_active-language"><img src="/img/flag-rus.png" alt=""><a href="">Русский</a></li>
                    <li><img src="/img/flag-uk.png" alt=""><a href="">English</a></li>
                    <li><img src="/img/flag-fr.png" alt=""><a href="">Français</a></li>
                    <li><img src="/img/flag-gr.png" alt=""><a href="">Deutsch</a></li>
                    <li><img src="/img/flag-es.png" alt=""><a href="">Español</a></li>
                </ul>
                <p>Валюта</p>
                <ul>
                    <li class="header_middle-info_active-language"><span>₽</span><a href="">Рубль РФ</a></li>
                    <li><span>$</span><a href="">Доллар США</a></li>
                    <li><span>£</span><a href="">Английский фунт</a></li>
                    <li><span>€</span><a href="">Евро</a></li>
                </ul>
            </div>
        </div>
        <div class="mobile_menu-phone">
            <div class="header_communications-phone">
                <span>Поддержка: </span>
                <a href="tel:+74952680496">+7 (495) 268-04-96</a>
            </div>
        </div>
    </div>
    <div class="header">
        <div class="header_communications">
            <div class="container clearfix">
                <div class="header_communications-phone">
                    <span>Поддержка: </span>
                    <a href="tel:+74952680496">+7 (495) 268-04-96</a>
                </div>
                <div class="header_social-block">
                    <span>Напишите нам</span>
                    <div class="header_social-block_img">
                        <a href="#"><img src="/img/whatsapp-logo.png" alt=""></a>
                        <a href="#"><img src="/img/telegram-logo.png" alt=""></a>
                        <a href="#"><img src="/img/vk.png" alt=""></a>
                    </div>
                    <a class="header_social-block_arrow-down">
                        <img src="/img/social-down.png" alt="">
                    </div>
                    <div class="header_social-block_hidden">
                        <a href="#"><img src="/img/viber-logo.png" alt=""></a>
                        <a href="#"><img src="/img/fb-logo.png" alt=""></a>
                        <a href="#"><img src="/img/gp-logo.png" alt=""></a>
                        <a href="#"><img src="/img/skype-logo.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header_middle-info">
            <div class="container clearfix">
                <div class="header_middle-info_burger">
                    <div class="header_middle-info_burger_wrap">
                        <div class="header_middle-info_burger_item"></div>
                        <div class="header_middle-info_burger_item"></div>
                        <div class="header_middle-info_burger_item"></div>
                    </div>
                </div>
                <a href="<?= Url::home() ?>">
                    <div class="header_middle-info_logo">
                        <img src="/img/logo.png" alt="">
                        <span class="header_middle-info_note">Note</span><span class="header_middle-info_store">store</span>
                    </div>
                </a>

                <div class="header_middle-info_find">
                    <?= \frontend\widgets\TitleSearchWidget::widget([]) ?>
                </div>
                <div class="header_middle-info_person-set">
                    <div class="header_middle-info_change-language">
                        <div class="header_middle-info_change-language_flag">
                            <img src="/img/flag-rus.png" alt="">
                        </div>
                        <div class="header_middle-info_change-language_currency">
                            <span>₽</span>
                        </div>
                    </div>
                    <div class="header_middle-info_change-language_hidden">
                        <p>Язык</p>
                        <ul>
                            <li class="header_middle-info_active-language"><img src="/img/flag-rus.png" alt=""><a href="">Русский</a></li>
                            <li><img src="/img/flag-uk.png" alt=""><a href="">English</a></li>
                            <li><img src="/img/flag-fr.png" alt=""><a href="">Français</a></li>
                            <li><img src="/img/flag-gr.png" alt=""><a href="">Deutsch</a></li>
                            <li><img src="/img/flag-es.png" alt=""><a href="">Español</a></li>
                        </ul>
                        <p>Валюта</p>
                        <ul>
                            <li class="header_middle-info_active-language"><span>₽</span><a href="">Рубль РФ</a></li>
                            <li><span>$</span><a href="">Доллар США</a></li>
                            <li><span>£</span><a href="">Английский фунт</a></li>
                            <li><span>€</span><a href="">Евро</a></li>
                        </ul>
                    </div>
                    <div class="header_middle-info_sign-in">
                        <a href="<?= Url::to(['auth/login']) ?>">Вход</a>
                        <a href="<?= Url::to(['auth/signup']) ?>">Регистрация</a>
                    </div>
                    <div class="header_middle-info_basket">
                        <a href="<?= Url::to(['cart/view']) ?>"><div class="header_middle-info_basket-img active"></div><span id="cartCount"><?= $this->params['cartCount'] ?></span></a>
                    </div>
                </div>
                <?php if (Yii::$app->controller->id == 'cart'): ?>
                    <div class="basket_communications-phone">
                        <span>Поддержка: </span>
                        <a href="tel:+74952680496">+7 (495) 268-04-96</a>
                    </div>
                    <a class="back__btn" href="<?= Yii::$app->request->getHostName() == parse_url($referrer = Yii::$app->request->referrer)['host'] ? $referrer : Url::to(['arrangement/list']) ?>">← Вернуться к покупкам</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="header_bottom-navigate">
            <div class="container">
                <div class="header_bottom-navigate_wrap">
                    <ul>
                        <?php $controller = Yii::$app->controller ?>
                        <li<?= $controller->id == 'artist' ? ' class="active"' : '' ?>><a href="<?= Url::to(['artist/list']) ?>">Музыканты</a></li>
                        <li<?= $controller->action->id != 'genre' && $controller->id == 'arrangement' ? ' class="active"' : '' ?>><a href="<?= Url::to(['arrangement/list']) ?>">Аранжировки</a></li>
                        <li<?= $controller->action->id == 'genre' && $controller->id == 'arrangement' ? ' class="active"' : '' ?>><a href="<?= Url::to(['arrangement/genre']) ?>">Жанры</a></li>
                        <li<?= $controller->id == 'note-pack' ? ' class="active"' : '' ?>><a href="<?= Url::to(['note-pack/list']) ?>">Нотные наборы</a></li>
                        <li class="header_bottom-navigate_order<?= $controller->id == 'order' ? '  active' : '' ?>">
                            <img src="/img/notes-icon.png" alt="">
                            <a href="<?= Url::to(['order/index']) ?>">Заказать ноты</a>
                        </li>
                        <li><a class="header_bottom-navigate_to-shop" href="#">Магазин музыкальных инструментов</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="main_content">
        <?php if(!empty($this->params['breadcrumbs'])): ?>
        <div class="breadcrumbs">
            <div class="container clearfix">
                <?php foreach ($this->params['breadcrumbs'] as $breadcrumb): ?>
                    <?php if(is_array($breadcrumb)): ?>
                        <a href="<?= Url::to($breadcrumb['url']) ?>"><?= $breadcrumb['label'] ?></a>
                        <?= next($this->params['breadcrumbs']) ? '→' : '' ?>
                    <?php elseif(is_string($breadcrumb)): ?>
                        <span><?= $breadcrumb ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?= $content ?>
    </div>

    <div class="footer">
        <div class="footer_banner-block">
            <div class="footer_banner-wrap">
                <div class="container">
                    <div class="footer_banner-text">
                        <div class="footer_banner-logo">
                            <span>Фоно</span><span>фактура</span>
                        </div>
                        <div class="footer_banner-desc">
                            <p>Магазин музыкальных инструментов</p>
                        </div>
                        <div class="footer_banner-list">
                            <ul>
                                <li>Большой выбор музыкальных инструментов</li>
                                <li>Бесплатная доставка в 200 городов России</li>
                                <li>Покупка в рассрочку 0/0/24</li>
                            </ul>
                        </div>
                        <div class="footer_banner-link">
                            <a href="#">Перейти в магазин</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom-block">
            <div class="footer_bottom-wrap">

                <div class="footer_bootom-list-wrap clearfix">
                    <div class="footer_bottom-list">
                        <ul>
                            <li><a href="#">Музыканты</a></li>
                            <li><a href="#">Аранжировки</a></li>
                            <li><a href="#">Жанры</a></li>
                            <li><a href="#">Нотные наборы</a></li>
                            <li class="footer_bottom-navigate_order"><img src="/img/f-notes-icon.png" alt=""><a href="#">Заказать ноты</a></li>
                            <li><a class="footer_bottom-navigate_to-shop" href="#">Магазин музыкальных инструментов</a></li>
                        </ul>
                    </div>
                    <div class="footer_bottom-socials">
                        <a href="#" class="footer_bottom-socials_fb"></a>
                        <a href="#" class="footer_bottom-socials_vk"></a>
                        <a href="#" class="footer_bottom-socials_tw"></a>
                        <a href="#" class="footer_bottom-socials_yt"></a>
                    </div>
                </div>
            </div>
            <div class="footer_bottom-info">
                <div class="container">
                    <a href="javascript:void(0)" class="footer_bottom-logo">Notestore</a>
                    <span>© 2017 Notestore.com. Все права защищены.</span>
                    <a href="#">Политика в отношении обработки персональных данных</a>
                </div>
            </div>

        </div>
    </div>
    <!-- modal window -->
    <div id="error-modal" class="modal_error-modal">
        <div class="modal_content">
            <p class="modal_title">Извините, возникла ошибка</p>
            <p class="modal_message">Возникла ошибка из-за временной перегрузки или отключения на техническое обслуживание сервера,
                <b>приносим свои извинения, ошибка скоро будет устранена.</b>
            </p>
            <p class="modal_message">Пожалуйста, повторите попытку позже.</p>
            <a href="#" class="modal_ok-close">Ок</a>
        </div>
    </div>
    <div class="overlay"></div>
    <div class="menu-overlay"></div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>