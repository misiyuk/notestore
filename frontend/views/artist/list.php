<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\caching\TagDependency;

/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \store\forms\frontend\ArtistFilterForm $filterForm
 * @var \yiidreamteam\upload\ImageUploadBehavior|\store\entities\Artist $artist
 */

$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = 'Музыканты';
?>
<div class="workarea">
    <div class="container">
        <h1>Музыканты</h1>
        <div class="content_info-block">
            <p class="page_description">Физическая основа музыкального инструмента, производящего музыкальные
                звуки (за исключением электрических устройств), это резонатор. Это может быть струна, столб
                воздуха в некотором объёме, колебательный контур, или иной объект, способный запасать
                подведённую энергию в виде колебаний. Резонансная частота резонатора определяет основной тон
                (первый обертон) производимого звука.</p>
            <a href="#description-link" class="page_description_show-link">Читать полностью</a>
        </div>
    </div>

    <?php ActiveForm::begin(['id' => 'filter-form']) ?>
        <div class="filter-block">
            <div class="container">
                <div class="filter-block_wrap">
                    <div class="filter-block_select">
                        <div class="filter-block_search">
                            <input type="text" name="<?= Html::getInputName($filterForm, 'query') ?>" value="<?= $filterForm->query ?>" placeholder="Поиск по музыкантам">
                            <button type="submit"><img src="/img/filter-search.png" alt=""></button>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function pjaxReload() {
                            var form = $('#filter-form');
                            $.pjax.reload('#<?= \yii\widgets\Pjax::$autoIdPrefix . \yii\widgets\Pjax::$counter ?>', {
                                history: true,
                                type: 'POST',
                                url: '<?= \yii\helpers\Url::to(['artist/list']) ?>?' + form.serialize()
                            });
                        }
                        window.onload = function() {
                            document.getElementById('filter-form').addEventListener('keyup', function () {
                                pjaxReload();
                            });
                        };
                    </script>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?>
    <?php Pjax::begin() ?>
    <?php $sqlQuery = $dataProvider->query->createCommand()->getRawSql();
    if ($this->beginCache($sqlQuery, ['dependency' => new TagDependency(['tags' => 'artistList'])])) : ?>
        <div class="filter_sort-result">
            <div class="container clearfix">
                <div class="filter_count-result">
                    <?php
                    $count = $dataProvider->count;
                    $from = $count > 0 ? $dataProvider->pagination->offset + 1 : 0;
                    $to = $dataProvider->pagination->offset + $count;
                    ?>
                    <span>Показаны результаты <?= $from ?>-<?= $to ?> из <?= $dataProvider->totalCount ?></span>
                </div>
                <div class="filte_tags-from-select">

                </div>
                <div class="filter_choose-sort">
                    <a href="#" class="filter_choose-sort_head">
                        Сортировать по
                    </a>
                    <div class="filter_choose-sort_items">
                        <a href="#" class="filter_choose-sort_item active">Цена по убыванию</a>
                        <a href="#" class="filter_choose-sort_item">Цена по возрастанию</a>
                        <a href="#" class="filter_choose-sort_item">По популярности</a>
                        <a href="#" class="filter_choose-sort_item">Новые поступления</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="note_musicians">
            <div class="container">
                <div class="note_musicians-wrap clearfix">
                    <?php foreach ($dataProvider->models as $artist): ?>
                    <div class="note_musicians-item">
                        <div>
                            <img src="<?= $artist->getThumbFileUrl('preview_image', 'thumb') ?>">
                            <a href="<?= \yii\helpers\Url::to(['artist/view', 'id' => $artist->id]) ?>" data-pjax="0"><?= $artist->name ?></a>
                        </div>
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
            <div class="note_full-description" id="description-link">
                <div class="container">
                    <h2>Жанры</h2>
                    <p>Физическая основа музыкального инструмента, производящего музыкальные звуки (за исключением
                        электрических устройств), это резонатор. Это может быть струна, столб воздуха в некотором
                        объёме, колебательный контур, или иной объект, способный запасать подведённую энергию в виде
                        колебаний. Резонансная частота резонатора определяет основной тон (первый обертон)
                        производимого звука. Инструмент может производить столько звуков одновременно, сколько
                        резонаторов в нём смонтировано. Звучание начинается в момент ввода энергии в резонатор.
                        Резонансные частоты резонаторов некоторых инструментов часто можно плавно или дискретно
                        изменять в процессе игры на инструменте. Для принудительного прекращения звучания можно
                        использовать демпфирование.</p>
                    <p>Развитие электроники в начале XX века повлекло за собой возникновение электромузыкальных
                        инструментов; первый из них (терменвокс) был создан в 1917 году. Современные синтезаторы
                        звука имитируют звучание всех известных музыкальных инструментов, а кроме того, и
                        всевозможных шумов (например, пение птиц, раскаты грома, звук проходящего поезда и т. д.).
                        Чаще всего синтезаторы оснащены клавиатурой фортепианного типа.</p>
                    <p>Наряду с сугубо электронным синтезом звука, в XX веке широко распространилось оснащение
                        акустических музыкальных инструментов (разновидности гитары, клавикорд и др.) адаптерами,
                        контроллерами и т.п. электронными устройствами. Группа таких инструментов получила название
                        электроакустических.</p>
                </div>
            </div>
        </div>
        <?php $this->endCache(); ?>
    <?php endif; ?>
    <?php Pjax::end() ?>
</div>