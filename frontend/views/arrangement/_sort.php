<?php
use store\helpers\CacheHelper;
use yii\caching\TagDependency;
/**
 * @var string $sort
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
?>
<div class="filter_sort-result">
    <div class="container clearfix">
        <?php if ($this->beginCache(
            'arrangementCountItems' . CacheHelper::key($dataProvider, [$dataProvider->pagination->page, $sort]),
            [
                'dependency' => new TagDependency(['tags' => 'arrangement']),
                'duration' => 0
            ]
        )): ?>
            <div class="filter_count-result">
                <?php
                $count = $dataProvider->count;
                $from = $count > 0 ? $dataProvider->pagination->offset + 1 : 0;
                $to = $dataProvider->pagination->offset + $count;
                ?>
                <span>Показаны результаты <?= $from ?>-<?= $to ?> из <?= $dataProvider->totalCount ?></span>
            </div>
            <?php $this->endCache() ?>
        <?php endif; ?>
        <div class="filte_tags-from-select">

        </div>
        <div class="filter_choose-sort">
            <?php ob_start(); ?>
            <div class="filter_choose-sort_items">
                <?php /** @var $sort */ ?>
                <a onclick="$('#sortList').val('-price'); pjaxReload();" class="filter_choose-sort_item<?= $sort == '-price' ? ' active' : '' ?>"><?= $sortName['-price'] = 'Цена по убыванию' ?></a>
                <a onclick="$('#sortList').val('price'); pjaxReload();" class="filter_choose-sort_item<?= $sort == 'price' ? ' active' : '' ?>"><?= $sortName['price'] = 'Цена по возрастанию' ?></a>
                <a onclick="$('#sortList').val('-view_count'); pjaxReload();" class="filter_choose-sort_item<?= $sort == '-view_count' ? ' active' : '' ?>"><?= $sortName['-view_count'] = 'По популярности' ?></a>
                <a onclick="$('#sortList').val('-id'); pjaxReload();" class="filter_choose-sort_item<?= $sort == '-id' ? ' active' : '' ?>"><?= $sortName['-id'] = 'Новые поступления' ?></a>
            </div>
            <?php $sortList = ob_get_clean(); ?>
            <a href="#" class="filter_choose-sort_head">
                <?= isset($sortName[$sort]) ? $sortName[$sort] : 'Сортировать по' ?>
            </a>
            <?= $sortList ?>
        </div>
    </div>
</div>