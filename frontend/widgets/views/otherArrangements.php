<?php
/**
 * @var \store\entities\Arrangement[]|\yiidreamteam\upload\ImageUploadBehavior[] $arrangements
 * @var \store\entities\ArrangementType[] $arrangementTypes
 * @var int $arrangementTypeId
 * @var string $title
 */
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\widgets\OtherArrangementsWidget;
?>

<div class="slider__block artist">
    <h2><?= $title ?></h2>
    <div class="slider__filter">
        <a class="filter__head" href="#">
            Все инструменты
        </a>
        <div class="filter__items">
            <a class="filter__item active" href="#" onclick="pjaxReload('<?= Url::current([OtherArrangementsWidget::class . '[arrangementTypeId]' => 0]) ?>')">
                Все инструменты
            </a>
            <?php foreach ($arrangementTypes as $arrangementType): ?>
                <a class="filter__item" onclick="pjaxReload('<?= Url::current([OtherArrangementsWidget::class . '[arrangementTypeId]' => $arrangementType->id]) ?>')" href="#">
                    <?= $arrangementType->name ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php Pjax::begin() ?>
    <div class="notes-slider js-notes-slider js-slider">
        <?php foreach ($arrangements as $i => $arrangement): ?>
            <?php if ($i%2 == 0): ?>
            <div class="slider__item">
            <?php endif; ?>
                <div class="slider__item_wrap">
                    <div class="item__link">
                        <div class="item__img">
                            <img src="<?= $arrangement->getThumbFileUrl('preview_image', 'arrangement_list') ?>">
                        </div>
                        <a href="<?= Url::to(['arrangement/view', 'id' => $arrangement->id]) ?>" data-pjax="0" class="item__name">
                            <?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?>,
                            <?= $arrangement->year ?>
                        </a>
                    </div>
                    <div class="item__text">
                        <div class="item__description">
                            <?= $arrangement->arrangementType->name ?>
                        </div>
                        <div class="item-price">
                            <?= Yii::$app->formatter->asCurrency($arrangement->mainSaleOffer->price) ?>
                        </div>
                    </div>
                </div>
            <?php if ($i%2 == 1): ?>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($i%2 == 0): ?>
        </div>
        <?php endif; ?>
    </div>
    <?php Pjax::end() ?>
</div>

<script type="text/javascript">
    function pjaxReload(url) {
        $.pjax.reload('#<?= Pjax::$autoIdPrefix . (Pjax::$counter - 1) ?>', {
            history: false,
            type: 'POST',
            url: url
        });
    }
    window.onload = function () {
        $(document).on('pjax:success', function() {
            sliderInit();
        });
    }
</script>