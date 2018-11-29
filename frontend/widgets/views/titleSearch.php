<?php
/**
 * @var \store\entities\TitleSearch[] $elements
 * @var \store\forms\frontend\TitleSearchForm $model
 * @var \yii\web\View $this
 */
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<form id="titleSearchForm">
    <div class="header_middle-info_find_wrap">
        <input id="titleSearch" type="text" name="<?= Html::getInputName($model, 'query') ?>" value="" placeholder="Поиск по нотам, музыкантам" type="search" class="header_middle-info_find-input">
        <button type="button" class="header_middle-info_find-button"><img src="/img/input-find.png" alt=""></button>
    </div>
    <div class="header_middle-info_result">
        <div class="header_middle-info_result_content nano">
            <div class="nano-content">
                <?php Pjax::begin() ?>
                <?php foreach ($elements as $element): ?>
                    <a href="<?= $element->url() ?>" data-pjax="0"><?= $element->title() ?></a>
                <?php endforeach; ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</form>

<?php ob_start() ?>
    function titleSearchReload(query) {
        $.pjax.reload('#<?= Pjax::$autoIdPrefix . (Pjax::$counter - 1) ?>', {
            history: false,
            type: 'POST',
            url: '<?= Url::current([Html::getInputName($model, 'query') => '']) ?>' + query
        });
    }

    $(function () {
        var titleSearch = $('#titleSearch');
        titleSearch.keyup(function() {
            titleSearchReload(titleSearch.val());
        });
        $('.header_middle-info_find-button').click(function() {
            titleSearchReload(titleSearch.val());
            return false;
        });
    });
<?php $this->registerJs(ob_get_clean()) ?>