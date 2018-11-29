<?php
use yii\helpers\Url;
use yii\caching\TagDependency;
use store\helpers\PriceHelper;

/**
 * @var \yiidreamteam\upload\ImageUploadBehavior|\store\entities\NotePack $notePack
 * @var \yiidreamteam\upload\ImageUploadBehavior|\store\entities\Arrangement $arrangement
 * @var \store\readModels\ArrangementReadModel $arrangementReadModel
 * @var \store\readModels\NotePackReadModel $notePackReadModel
 * @var \yii\web\View $this
 */
?>
<div class="index_big-slider_hidden">
    <div class="index_big-slider-wrap">
        <div class="index_big-slider">
            <a href="#" style="background-image: url('/img/index-lala.jpg');">
                <div class="index_big-slider_text">
                    <p class="index_big-slider_head">LA LA LAND</p>
                    <p  class="index_big-slider_desc">Original notes</p>
                </div>
            </a>
            <a href="#" style="background-image: url('/img/index-lala.jpg');"> </a>
            <a href="#" style="background-image: url('/img/index-lala.jpg');"> </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="musical-sets-wrap">
        <h2>Нотные наборы</h2>
        <div class="musical-sets_slider">
            <?php if ($this->beginCache('lastNotePacksHome', ['dependency' => new TagDependency(['tags' => 'lastNotePacks'])])): ?>
                <?php foreach ($notePackReadModel->getLast(5) as $notePack): ?>
                <div class="musical-sets_slider_item">
                    <div class="musical-sets_slider_item-wrap">
                        <div class="musical-sets_slider_img">
                            <img width="185" height="172" src="<?= $notePack->getThumbFileUrl('preview_image', 'thumb') ?>">
                            <div class="musical-sets_slider_img-back"></div>
                        </div>
                        <a href="<?= Url::to(['note-pack/view', 'id' => $notePack->id]) ?>" about="исправить ссылку на карточку" class="musical-sets_note-name"><?= $notePack->name ?></a>
                        <div class="musical-sets_price">
                            <?php if ($notePack->mainSaleOffer->price > 0) {
                                echo '<p class="note_sets-price">' . PriceHelper::asCurrency($notePack->mainSaleOffer->price) . '</p>';
                            } else {
                                echo '<p class="note_sets-price-free">Бесплатно</p>';
                            } ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php $this->endCache(); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="index_column-wrap">
        <div class="index_column-wrap_left">
            <h2>Популярные ноты</h2>
            <div class="index_column-block">
                <?php if ($this->beginCache('popularArrangementsHome', ['dependency' => new TagDependency(['tags' => 'popularArrangements'])])): ?>
                    <?php foreach ($arrangementReadModel->getPopular(5) as $arrangement): ?>
                        <div class="index_column-item clearfix">
                            <div class="index_column-item_name">
                                <div class="index_column-item_link">
                                    <img width="60" height="60" src="<?= $arrangement->getThumbFileUrl('preview_image', 'small_list') ?>">
                                    <a href="<?= Url::to(['arrangement/view', 'id' => $arrangement->id]) ?>"><?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?>, <?= $arrangement->year ?></a>
                                </div>
                            </div>
                            <div class="index_column-item_desc">
                                <span><?= $arrangement->arrangementType->name ?></span>
                            </div>
                            <div class="index_column-item_price">
                                <?php
                                if ($arrangement->mainSaleOffer->price > 0) {
                                    echo '<span>' . PriceHelper::asCurrency($arrangement->mainSaleOffer->price) . '</span>';
                                } else {
                                    echo '<span class="index_column-item_price-free">Бесплатно</span>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php $this->endCache() ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="index_column-wrap_right">
            <h2>Новые поступления</h2>
            <div class="index_column-block">
                <?php if ($this->beginCache('newArrangementsHome', ['dependency' => new TagDependency(['tags' => 'newArrangements'])])): ?>
                    <?php foreach ($arrangementReadModel->getNew(5) as $arrangement): ?>
                        <div class="index_column-item clearfix">
                            <div class="index_column-item_name">
                                <div class="index_column-item_link">
                                    <img width="60" height="60" src="<?= $arrangement->getThumbFileUrl('preview_image', 'small_list') ?>">
                                    <a href="<?= Url::to(['arrangement/view', 'id' => $arrangement->id]) ?>"><?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?>, <?= $arrangement->year ?></a>
                                </div>
                            </div>
                            <div class="index_column-item_desc">
                                <span><?= $arrangement->arrangementType->name ?></span>
                            </div>
                            <div class="index_column-item_price">
                                <?php
                                if ($arrangement->mainSaleOffer->price > 0) {
                                    echo '<span>' . PriceHelper::asCurrency($arrangement->mainSaleOffer->price) . '</span>';
                                } else {
                                    echo '<span class="index_column-item_price-free">Бесплатно</span>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php $this->endCache() ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>