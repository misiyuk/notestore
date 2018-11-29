<?php
/**
 * @var string $title
 * @var \store\entities\Artist[]|\yiidreamteam\upload\ImageUploadBehavior[] $artists
 */
?>
<div class="similar__block artist">
    <div class="container clearfix">
        <div class="similar__block_wrap">
            <h2><?= $title ?></h2>
            <div class="similar__block-slider js-similar__block-slider js-slider">
                <?php foreach ($artists as $artist): ?>
                    <div class="slider__item">
                        <div class="slider__item_wrap">
                            <div class="item__link">
                                <div class="item__img">
                                    <img src="<?= $artist->getThumbFileUrl('preview_image', 'thumb') ?>">
                                </div>
                                <a href="<?= \yii\helpers\Url::to(['artist/view', 'id' => $artist->id]) ?>" class="item__name">
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