<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\caching\TagDependency;
use store\helpers\CacheHelper;
/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \store\forms\frontend\ArrangementFilterForm $filterForm
 * @var string $sort
 */

$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = 'Аранжировки';

\frontend\assets\NoUiSliderAsset::register($this);
?>
<div class="workarea">
    <div class="container">
        <h1>Аранжировки</h1>
        <div class="content_info-block">
            <p class="page_description">Физическая основа музыкального инструмента, производящего музыкальные
                звуки (за исключением электрических устройств), это резонатор. Это может быть струна, столб
                воздуха в некотором объёме, колебательный контур, или иной объект, способный запасать
                подведённую энергию в виде колебаний. Резонансная частота резонатора определяет основной тон
                (первый обертон) производимого звука.</p>
            <a href="#description-link" class="page_description_show-link">Читать полностью</a>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
            'id' => 'filter-form'
        ]
    ]); ?>
    <?php if ($this->beginCache(
        'arrangementListFilter' . CacheHelper::key($dataProvider),
        [
            'dependency' => new TagDependency(['tags' => 'arrangement']),
            'duration' => 0,
        ]
    )): ?>
        <div class="filter-block">
            <div class="container">
                <div class="filter-block_wrap">
                    <div class="filter-block_select">
                        <?php if($filterForm->arrangementTypeCount): ?>
                            <div class="filter-block_select-wrap" style="background: rgb(241, 241, 241);">
                                <span>Выбрано (<?= $filterForm->arrangementTypeCount ?>)</span>
                                <img src="/img/ar-d.png" alt="">
                            </div>
                        <?php else: ?>
                            <div class="filter-block_select-wrap">
                                <span>Выберите аранжировку</span>
                                <img src="/img/ar-d.png" alt="">
                            </div>
                        <?php endif; ?>

                        <div class="filter-block_select_result">
                            <div class="filter-block_select_result_content nano-select">
                                <div class="nano-content">
                                    <?php foreach ($filterForm->arrangementTypeList as $i => $arrangementType): ?>
                                        <div class="filter-block_select_result-item<?= $checked = ($filterForm->arrangementTypeIsChecked($arrangementType->id) ? ' checked' : '') ?>">
                                            <input type="checkbox" id="arrangementType<?= $i ?>" name="<?= Html::getInputName($filterForm, 'arrangementType[]') ?>" value="<?= $arrangementType->id ?>"<?= $checked ?>>
                                            <label for="arrangementType<?= $i ?>" style="text-transform: capitalize;"><?= $arrangementType->name ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="filter-block_select-year">
                        <?php if($filterForm->yearCount): ?>
                            <div class="filter-block_select-year-wrap" style="background: rgb(241, 241, 241);">
                                <span>Выбрано (<?= $filterForm->yearCount ?>)</span>
                                <img src="/img/ar-d.png" alt="X">
                            </div>
                        <?php else: ?>
                            <div class="filter-block_select-year-wrap">
                                <span>Год</span>
                                <img src="/img/ar-d.png" alt="X">
                            </div>
                        <?php endif; ?>

                        <div class="filter-block_select-year_result">
                            <div class="filter-block_select-year_result_content nano-select-year">
                                <div class="nano-content">
                                    <?php foreach ($filterForm->yearList as $i => $year): ?>
                                    <div class="filter-block_select-year_result-item<?= $checked = ($filterForm->yearIsChecked($year) ? ' checked' : '') ?>">
                                        <input type="checkbox" id="year<?= $i ?>" name="<?= Html::getInputName($filterForm, 'year[]') ?>" value="<?= $year ?>"<?= $checked ?>>
                                        <label for="year<?= $i ?>"><?= $year ?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block_scroller">
                        <div class="filter-block_scroller-wrap clearfix">
                            <span>Цена, руб.</span>
                            <div class="filter-block_scroller-block">
                                <input type="text" name="<?= Html::getInputName($filterForm, 'minPrice') ?>" class="filter-block_scroller-lower"
                                       id="lower-price">
                                <div class="filter-block_scroller-line" id="pricepicker"></div>
                                <input type="text" name="<?= Html::getInputName($filterForm, 'maxPrice') ?>" class="filter-block_scroller-upper"
                                       id="upper-price">
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function pjaxReload() {
                            var form = $('#filter-form');
                            $.pjax.reload('#<?= \yii\widgets\Pjax::$autoIdPrefix . \yii\widgets\Pjax::$counter ?>', {
                                history: true,
                                type: 'POST',
                                url: '<?= \yii\helpers\Url::to(['arrangement/list']) ?>?' + form.serialize()
                            });
                        }
                        window.onload = function() {
                            var snapSlider = document.getElementById('pricepicker');
                            if (snapSlider) {
                                noUiSlider.create(snapSlider, {
                                    start: [<?= $filterForm->minPrice ?: $filterForm->minPriceInterval ?>, <?= $filterForm->maxPrice !== null ? $filterForm->maxPrice : $filterForm->maxPriceInterval ?>],
                                    connect: true,
                                    range: {
                                        'min': <?= $filterForm->minPriceInterval ?>,
                                        'max': <?= $filterForm->maxPriceInterval ?>
                                    }
                                });

                                var snapValues = [
                                    document.getElementById('lower-price'),
                                    document.getElementById('upper-price')
                                ];
                                snapSlider.noUiSlider.on('end', function () {
                                    pjaxReload();
                                    document.getElementById('checkFree').checked = $('#upper-price').val() === "0";
                                });

                                snapSlider.noUiSlider.on('update', function (values, handle) {
                                    snapValues[handle].value = Math.floor(values[handle]);
                                });


                                document.getElementById('lower-price').addEventListener('change', function () {
                                    snapSlider.noUiSlider.set([this.value, null]);
                                    pjaxReload();
                                });

                                document.getElementById('upper-price').addEventListener('change', function () {
                                    snapSlider.noUiSlider.set([null, this.value]);
                                    document.getElementById('checkFree').checked = $('#upper-price').val() === "0";
                                    pjaxReload();
                                });

                                document.getElementById('checkFree').addEventListener('change', function () {
                                    if ($('#checkFree').prop("checked")) {
                                        snapSlider.noUiSlider.set([0, 0]);
                                    }
                                });

                                document.getElementById('filter-form').addEventListener('change', function () {
                                    pjaxReload();
                                });
                            }
                        };
                    </script>
                    <div class="filter-block_checkfree">
                        <div class="filter-block_checkfree-wrap">
                            <input type="checkbox" name="freeCheck" id="checkFree"<?= $filterForm->maxPrice === '0' ? ' checked' : '' ?>>
                            <label for="checkFree">Только бесплатные</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endCache() ?>
    <?php endif; ?>
        <input hidden id="sortList" name="sort" value="">
    <?php ActiveForm::end() ?>

    <?php \yii\widgets\Pjax::begin() ?>

        <div class="note_arrangements">

            <?= $this->render('_sort', [
                'sort' => $sort,
                'dataProvider' => $dataProvider,
            ]) ?>
            <?= $this->render('_items', [
                'dataProvider' => $dataProvider,
                'sort' => $sort,
            ]) ?>

            <div class="note_full-description" id="description-link">
                <div class="container">
                    <h2>Аранжировки</h2>
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
    <?php \yii\widgets\Pjax::end() ?>
</div>