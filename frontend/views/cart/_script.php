<?php
/**
 * @var \yii\web\View $this
 */
use yii\helpers\Url;
?>
<script>
<?php ob_start() ?>
$(".js-add-to-basket__btn").on("click", function () {
    $.ajax({
        url: "<?= Url::to(['cart/add']) ?>",
        data: $('#addCartItem').serialize(),
        method: 'post',
        success: function (response) {
            $.ajax({
                url: "<?= Url::to(['cart/count']) ?>",
                data: $('#addCartItem').serialize(),
                method: 'post',
                success: function (response) {
                    var result = JSON.parse(response);
                    $('#cartCount').html(result.cartCount);
                }
            });
        }
    });
});
<?php $this->registerJs(ob_get_clean()) ?>
</script>