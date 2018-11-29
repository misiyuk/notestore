<?php
/**
 * @var \yii\web\View $this
 * @var \store\forms\frontend\OrderForm $form
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="order-form-block">
    <div class="breadcrumbs">
        <div class="container clearfix">
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>">Главная</a>
            →
            <span>Заказ нот</span>
        </div>
    </div>
    <div class="workarea order-form">
        <div class="container">
            <h1>Закажи ноты любимой песни</h1>
            <div class="order-form_wrap">
                <div class="order-form_description">
                    <div class="order-form_description-wrap">
                        <p class="order-form_description-head">Создание нот любого произведения под заказ за <a
                                href="#get-notes">1 неделю</a></p>
                        <div class="order-form_description-list">
                            <p>В комплект входит:</p>
                            <ul>
                                <li>аккомпанемент песни;</li>
                                <li>аккомпанемент и вокал;</li>
                                <li>ноты в PDF файле</li>
                                <li>пример игры на фортепиано</li>
                                <li>исходный файл для корректировок</li>
                            </ul>
                        </div>
                        <p class="order-form_description-price">Цена: <span>1000 руб.</span></p>
                    </div>
                </div>
                <div class="order-form_send-block">
                    <?php ActiveForm::begin() ?>
                        <div class="order-form_send-block_wrap">
                            <div class="order-form_send-block_item">
                                <label>ФИО <span>*</span></label>
                                <input type="text" name="<?= Html::getInputName($form, 'fio') ?>" value="" class="order-form_send-block_name">
                                <span class="order_error-message">Укажите ФИО</span>
                            </div>
                            <div class="order-form_send-block_item">
                                <label>Ваш телефон <span>*</span></label>
                                <input type="text" name="<?= Html::getInputName($form, 'phone') ?>" value="" id="order-phone-input">
                                <span class="order_error-message">Укажите телефон</span>
                            </div>
                            <div class="order-form_send-block_item order-form_send-block_item-email">
                                <label>Ваш E-mail <span>*</span></label>
                                <input type="text" name="<?= Html::getInputName($form, 'email') ?>" value="" class="order-form_email">
                                <span class="order_error-message">Укажите E-mail</span>
                            </div>
                            <div class="order-form_send-block_item-button">
                                <button onclick="return false;" type="submit" disabled name="send-btn">Отправить</button>
                            </div>
                            <div class="order-form_send-block_item-check">
                                <input type="checkbox" id="check-order" name="<?= Html::getInputName($form, 'check') ?>">
                                <label for="check-order">Нажимая на кнопку «Отправить», я даю</label>
                                <a href="#">согласие на обработку персональных данных</a>
                            </div>
                        </div>
                    <?php ActiveForm::end() ?>
                    <script>
                        function checkForm(form){

                            if( !(form.find("input[name='<?= Html::getInputName($form, 'fio') ?>'], input[name='<?= Html::getInputName($form, 'phone') ?>'], input[name='<?= Html::getInputName($form, 'email') ?>'], input[name='<?= Html::getInputName($form, 'check') ?>']").hasClass('error')) && form.find("input[name='<?= Html::getInputName($form, 'fio') ?>'], input[name='<?= Html::getInputName($form, 'phone') ?>'], input[name='<?= Html::getInputName($form, 'email') ?>'], input[name='<?= Html::getInputName($form, 'check') ?>']").val().length > 0 && $("input[name='<?= Html::getInputName($form, 'check') ?>']").prop("checked") ){
                                form.find("button[name='send-btn']").addClass("active");
                                form.find("button[name='send-btn']").prop("disabled", false);
                                return true;
                            }
                            else{
                                form.find("button[name='send-btn']").removeClass("active");
                                form.find("button[name='send-btn']").prop("disabled", true);
                            }

                            return false;

                        }
                        window.onload = function () {
                            $('form button').on('click', function () {
                                $.ajax({
                                    url: '<?= \yii\helpers\Url::to(['order/index']) ?>?' + $('form').serialize(),
                                    success: function () {
                                        alert('Ваш заказ принят!');
                                    }
                                });
                            });
                            $("body").on("keyup change blur click", "input[name='<?= Html::getInputName($form, 'fio') ?>'], input[name='<?= Html::getInputName($form, 'phone') ?>'], input[name='<?= Html::getInputName($form, 'email') ?>'], input[name='<?= Html::getInputName($form, 'check') ?>']", function() {
                                console.log('asd');
                                phoneVal = $("input[name='<?= Html::getInputName($form, 'phone') ?>']").val();
                                var phoneMask = /^(\s*)?(\+)?([- ():=+]?\d[- ():=+]?){10,14}(\s*)?$/;
                                switch($(this).prop("name")){
                                    case "<?= Html::getInputName($form, 'fio') ?>":
                                        if($(this).val().length < 1 ){
                                            $(this).addClass("error");
                                            $(this).siblings(".order_error-message").show();
                                        }
                                        else{
                                            $(this).removeClass("error");
                                            $(this).siblings(".order_error-message").hide();
                                        }
                                        break;
                                    case "<?= Html::getInputName($form, 'phone') ?>":
                                        if(!phoneMask.test(phoneVal)){
                                            $(this).addClass("error");
                                            $(this).siblings(".order_error-message").show();
                                        }
                                        else{
                                            $(this).removeClass("error");
                                            $(this).siblings(".order_error-message").hide();
                                        }
                                        break;
                                    case "<?= Html::getInputName($form, 'email') ?>":
                                        var emailItem = $(this);
                                        checkEmail(emailItem);
                                        break;
                                    default:
                                        break;
                                }

                                checkForm($(this.form));

                            });
                        };
                    </script>
                    <div class="order_accepted-message js-ok-message">
                        <p>Ваша заявка принята!</p>
                        <p>Наш менеджер свяжется с Вами в рабочее время <br>
                            с 10:00 до 19:00, сб-вс выходной.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="workarea">
    <div class="our_advantages">
        <div class="container">
            <div class="our_advantages-wrap">
                <div class="our_advantages-item">
                    <div class="our_advantages-item-img">
                        <img src="img/or-adv1.png" alt="">
                    </div>
                    <div class="our_advantages-item-text">
                        <span>Все ноты создают профессиональные музыканты</span>
                    </div>
                </div>
                <div class="our_advantages-item">
                    <div class="our_advantages-item-img">
                        <img src="img/or-adv2.png" alt="">
                    </div>
                    <div class="our_advantages-item-text">
                        <span>Срок изготовления до 1 недели, но можно и быстрее</span>
                    </div>
                </div>
                <div class="our_advantages-item">
                    <div class="our_advantages-item-img">
                        <img src="img/or-adv3.png" alt="">
                    </div>
                    <div class="our_advantages-item-text">
                        <span>Любые произведения и песни</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="get_notes" id="get-notes">
        <div class="container">
            <div class="get_notes-wrap">
                <h3>Когда я получу ноты?</h3>
                <p>Средний срок изготовления нот - неделя. При необходимости выполнения заказа в более короткие
                    сроки, необходимо сообщить об этом <br>
                    при оформлении заказа. Возможно выполнения заказа за 1-2 дня при дополнительной оплате от
                    300 руб. <br>
                    (в зависимости от сложности заказа).</p>
            </div>
        </div>
    </div>
</div>