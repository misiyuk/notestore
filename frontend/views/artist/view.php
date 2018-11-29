<?php
/**
 * @var \yii\web\View $this
 * @var \store\entities\Artist|\yiidreamteam\upload\ImageUploadBehavior $artist
 */
use yii\helpers\Url;
use yii\helpers\Html;
use store\forms\frontend\ArrangementFilterForm;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Музыканты', 'url' => ['artist/list']];
$this->params['breadcrumbs'][] = $artist->name;

$this->params['wrapperClasses'] = 'note-artist-wrapper';
$this->title = $artist->name;
?>
<div class="workarea">
    <div class="container clearfix">
        <h1><?= $this->title ?></h1>
        <div class="artist__description">
            <div class="artist__img">
                <img src="<?= $artist->getThumbFileUrl('detail_image', 'detail') ?>">
            </div>
            <div class="artist__info">
                <div><!--Alekseev (Никита Алексеев) - украинский исполнитель, участвовал в 4-ом сезоне телешоу
                    «Голос
                    страны» в 2014 году. На слепых прослушиваниях к певцу повернулась Ани Лорак, но он не прошёл
                    дальше 1-го прямого эфира. <span class="hidden">В качестве утешительного приза наставница Ани Лорак помогла Никите
								снять первый клип на дебютный сингл «Всё успеть», но первой успешной композицией для
								исполнителя стала песня «А я пливу» из репертуара Ирины Билык, на которую был снят клип, что в
								течение нескольких недель держался на первом месте в чарте FDR. Сама Ирина Билык положительно
								отметила кавер на свою песню в исполнении Никиты и даже пригласила его петь на свой концерт
								«Билык. Лето.Танцуем»</span> <a class="show-all__btn js-show-all__btn"
                                                                href="#">Раскрыть</a>-->
                    <?= $artist->description ?>
                </div>
                <div class="artist__genre">
                    Жанр: <?php
                    foreach ($artist->genres as $i => $genre):
                        ?><?= $i ? ', ' : '' ?><a href="<?= Url::to([
                                'arrangement/genre',
                                Html::getInputName(new ArrangementFilterForm(), 'genre') => [$genre->id]
                            ]) ?>"><?= $genre->name ?></a><?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container clearfix">
        <?= \frontend\widgets\OtherArrangementsWidget::widget([
            'artist' => $artist,
            'title' => 'Ноты'
        ]) ?>
    </div>
    <a class="show-more__btn" href="#">
        <div>Показать еще</div>
    </a>
    <?= \frontend\widgets\LikeArtistsWidget::widget([
        'artist' => $artist
    ]) ?>
</div>