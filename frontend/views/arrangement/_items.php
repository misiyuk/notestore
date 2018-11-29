<?php
use store\helpers\PriceHelper;
use store\helpers\CacheHelper;
use yii\caching\TagDependency;
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var $this \yii\web\View
 * @var \store\entities\Arrangement|\yiidreamteam\upload\ImageUploadBehavior $arrangement
 * @var string $sort
 */
?>

<?php if ($this->beginCache(
    'arrangementItems' . CacheHelper::key($dataProvider, [$dataProvider->pagination->page, $sort]),
    [
        'dependency' => new TagDependency(['tags' => 'arrangement']),
        'duration' => 0
    ]
)): ?>
    <div class="container">
        <div class="note_arrangements-wrap clearfix">
            <?php foreach ($dataProvider->models as $arrangement): ?>
                <div class="note_arrangements-item">
                    <div>
                        <img src="<?= $arrangement->getThumbFileUrl('preview_image', 'arrangement_list') ?>">
                        <a data-pjax="0" href="<?= \yii\helpers\Url::to(['arrangement/view', 'id' => $arrangement->id]) ?>"><?= $arrangement->song->artistsString ?> - <?= $arrangement->song->name ?>, <?= $arrangement->year ?></a>
                    </div>
                    <p class="note_arrangements-type"><?= $arrangement->arrangementType->name ?></p>
                    <?php if ($arrangement->mainSaleOffer->price > 0) {
                        echo '<p class="note_arrangements-price">' . PriceHelper::asCurrency($arrangement->mainSaleOffer->price) . '</p>';
                    } else {
                        echo '<p class="note_arrangements-price-free">Бесплатно</p>';
                    } ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($dataProvider->pagination->pageCount): ?>
    <div class="note_pagination">
        <div class="container">
            <div class="note_pagination_wrap">
                <?php if ($dataProvider->pagination->page): ?>
                    <a href="<?= $dataProvider->pagination->links['prev'] ?>" class="note_pagination-prev"></a>
                <?php endif; ?>
                <?php for ($i = 0; $i < $dataProvider->pagination->pageCount; $i++): ?>
                    <a  href="<?= $dataProvider->pagination->createUrl($i) ?>"
                        <?= $dataProvider->pagination->page == $i ? 'class="note_pagination-active"' : '' ?>>
                        <?= $i + 1 ?>
                    </a>
                <?php endfor; ?>
                <?php if ($dataProvider->pagination->page + 1 !== $dataProvider->pagination->pageCount): ?>
                    <a href="<?= $dataProvider->pagination->links['next'] ?>" class="note_pagination-next"></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php $this->endCache() ?>
<?php endif; ?>

