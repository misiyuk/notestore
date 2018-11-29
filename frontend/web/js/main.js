$(document).ready(function() {
    if ($('[data-fancybox]').length > 0) {
        $('[data-fancybox]').fancybox();
    }
    $(".nano").nanoScroller();
    $(".nano-select").nanoScroller();
    $(".nano-select-year").nanoScroller();
    $(".header_middle-info_result").hide();

    //show header socials
    $("body").on("click", ".header_social-block_arrow-down", function() { 
    	$(".overlay").show();
    	$(".header_social-block_hidden").show();
    	$(".header_social-block_arrow-down img").attr('src', '/img/social-down-open.png');
    });

    //hide header socials
    jQuery(function($){
		$(document).mouseup(function (e){ 
			var arrowBlock = $(".header_social-block_hidden");
			if (!arrowBlock.is(e.target) ) { 
				$(".overlay").hide();
    			$(".header_social-block_hidden").hide();
    			$(".header_social-block_arrow-down img").attr('src', '/img/social-down.png');
			}
		});
	});
    jQuery(function($){
        $(document).mouseup(function (e){ 
            var langBlock = $(".header_middle-info_person-set .header_middle-info_change-language_hidden");
            if (!langBlock.is(e.target)  && langBlock.has(e.target).length === 0) { 
                langBlock.hide();
            }
        });
    });

    //change language
    $("body").on("click", ".header_middle-info_change-language", function() { 
        $(".header_middle-info_change-language_hidden").toggle();
    });
    $("body").on("click", ".header_middle-info_change-language_mobile", function() { 
        $(".mobile_menu-country .header_middle-info_change-language_hidden").slideToggle("normal");
        var langOpen = $(".mobile_menu-country_wrap");
        if (langOpen.hasClass("opened-language") ){
            langOpen.css("border-bottom", "1px solid rgb(235, 235, 235)").removeClass("opened-language");
        }
        else{
            langOpen.addClass("opened-language").css("border", "none");
        }
    });
    if($(window).width() <= 850) {
         $(".header_middle-info_change-language_hidden").hide();
    }
    $(window).resize(function() { 
        if($(window).width() <= 850) {
             $(".header_middle-info_change-language_hidden").hide();
        }
    });

    //open mobile menu
    $("body").on("click", ".header_middle-info_burger", function() { 
        $(".mobile_menu-block").addClass("mobile_menu-block_opened");
        $(".menu-overlay").show();
    });
    $("body").on("click", ".mobile_menu-close", function() { 
        $(".mobile_menu-block").removeClass("mobile_menu-block_opened");
        $(".menu-overlay").hide();
    });

    jQuery(function($){
        $(document).mouseup(function (e){ 
            var mobMenu = $(".mobile_menu-block");
            if (!mobMenu.is(e.target)  && mobMenu.has(e.target).length === 0) { 
                mobMenu.removeClass("mobile_menu-block_opened");
                $(".menu-overlay").hide();
            }
        });
    });

    // full search
    $("body").on("focus", ".header_middle-info_find-input", function() {
        $(".header_middle-info_result").addClass("visible").show();
        $(".nano").nanoScroller();
    });

    $("body").on("click", function(e) {
        var searchRes = $(".header_middle-info_result");
        if (!$(".header_middle-info_find-input").is(e.target) && !searchRes.is(e.target) && searchRes.has(e.target).length === 0) {
            searchRes.removeClass("visible").hide();
        }
    })

    $("body").on("keydown", function(e) {
        if (e.keyCode == 27 && $(".header_middle-info_result").hasClass("visible")) {
            $(".header_middle-info_result").removeClass("visible").hide();
            $(".header_middle-info_find-input").blur();
        }
    })
    
    //index big slaider
    if($('.index_big-slider').length > 0)    {
        $('.index_big-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            prevArrow: '<div class="index_arrow_prev"></div>',
            nextArrow: '<div class="index_arrow_next"></div>',
        });
    }
    $(window).on('resize', function() {
        setTimeout(function() {
            $('.index_big-slider').slick('setPosition');
        },300);
    });
    //index note slaider
    if($('.musical-sets_slider').length > 0)    {
        $('.musical-sets_slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            variableWidth: true,
            prevArrow: '<div class="musical-sets_prev"></div>',
            nextArrow: '<div class="musical-sets_next"></div>',
              responsive: [
    {
      breakpoint: 851,
      settings: {
        slidesToShow: 3,
        variableWidth: false
      }
    },    
    {
      breakpoint: 730,
      settings: {
        slidesToShow: 2,
        variableWidth: false
      }
    },
    {
      breakpoint: 530,
      settings: {
        slidesToShow: 1,
        variableWidth: false
      }
    }

  ]
        });
    }

    if($(window).width() < 1250 && $(window).width() > 850 ) {
        $(".musical-sets_slider_item-wrap").each(function() {
            $(this).css({"margin-right" : 147 - (1250 - $(window).width())/3 + "px"});
        })

    } else {
        $(".musical-sets_slider_item-wrap").each(function() {
            $(this).removeAttr("style");
        })
    }

    $(window).resize(function() {
        if($(window).width() < 1250 && $(window).width() > 850 ) {
            $(".musical-sets_slider_item-wrap").each(function() {
                $(this).css({"margin-right" : 147 - (1250 - $(window).width())/3 + "px"});
            })

        } else {
            $(".musical-sets_slider_item-wrap").each(function() {
                $(this).removeAttr("style");
            })
        }
    });

    //filter select
    $("body").on("click", function(e) {
        var searchRes = $(".filter-block_select_result");
        if ( !searchRes.is(e.target) && searchRes.has(e.target).length === 0 && 
            !$(".filter-block_select-wrap").is(e.target)  && !$(".filter-block_select-wrap").is(e.target) && $(".filter-block_select-wrap").has(e.target).length === 0){
            searchRes.removeClass("visible").hide();
            $(".filter-block_select-wrap").removeClass("opened-select");
        }
    });

    $("body").on("click", ".filter-block_select-wrap", function() { 
        if($(this).hasClass("opened-select")){
            $(".filter-block_select_result").removeClass("visible").hide();
            $(this).removeClass("opened-select");
        }
        else{
            $(".filter-block_select_result").addClass("visible").show();
            $(this).addClass("opened-select");
            $(".nano-select").nanoScroller();
        }
    });

    $("body").on("click", ".filter-block_select_result-item label", function() {
        if($(this).siblings("input").prop("checked")){
            $(this).parent(".filter-block_select_result-item").removeClass("checked");
            $(".filte_tags-from-select span:contains("+ $(this).text() +")").remove();
        }
        else{
            $(this).parent(".filter-block_select_result-item").addClass("checked");
            $("<span><img src='/img/cl-tags.png' alt='X'>" + $(this).text() + "</span>").appendTo(".filte_tags-from-select");
        }
        var checkedCount = $(".filter-block_select_result-item.checked").length;
        if(checkedCount > 0){
            $(".filter-block_select-wrap span").text("Выбрано (" + checkedCount + ")");
            $(".filter-block_select-wrap").css("background", "#F1F1F1");
        }
        else{
            $(".filter-block_select-wrap span").text("Выберите аранжировку");
            $(".filter-block_select-wrap").css("background", "#FFF");
        }
    });

    $("body").on("click", ".filte_tags-from-select span img", function() {;
        $(".filter-block_select_result-item.checked label:contains("+ $(this).parent(".filte_tags-from-select span").text() +")").parent(".filter-block_select_result-item").removeClass("checked").children('input').prop('checked', false);
        $(this).parent(".filte_tags-from-select span").remove();
        var checkedCount = $(".filter-block_select_result-item.checked").length;
        if(checkedCount > 0){
            $(".filter-block_select-wrap span").text("Выбрано (" + checkedCount + ")");
            $(".filter-block_select-wrap").css("background", "#F1F1F1");
        }
        else{
            $(".filter-block_select-wrap span").text("Выберите аранжировку");
            $(".filter-block_select-wrap").css("background", "#FFF");
        }
        pjaxReload()
    });

    //year select
    $("body").on("click", ".filter-block_select-year-wrap", function() { 
        if($(this).hasClass("opened-select-year")){
            $(".filter-block_select-year_result").removeClass("visible").hide();
            $(this).removeClass("opened-select-year");
        }
        else{
            $(".filter-block_select-year_result").addClass("visible").show();
            $(this).addClass("opened-select-year");
            $(".nano-select-year").nanoScroller();
        }
    });

    $("body").on("click", function(e) {
        var searchRes = $(".filter-block_select-year_result");
        var searchBlock = $(".filter-block_select-year-wrap");
        if ( !searchRes.is(e.target) && searchRes.has(e.target).length === 0 && 
            !searchBlock.is(e.target) && searchBlock.has(e.target).length === 0){
            searchRes.removeClass("visible").hide();
            searchBlock.removeClass("opened-select-year");
        }
    });

    $("body").on("click", ".filter-block_select-year_result-item label", function() { 
        if($(this).parent(".filter-block_select-year_result-item").hasClass("checked")){
            $(this).parent(".filter-block_select-year_result-item").removeClass("checked");
        }
        else{
            $(this).parent(".filter-block_select-year_result-item").addClass("checked");
        }
        var checkedCount = $(".filter-block_select-year_result-item.checked").length;
        if(checkedCount > 0){
            $(".filter-block_select-year-wrap span").text("Выбрано (" + checkedCount + ")");
            $(".filter-block_select-year-wrap").css("background", "#F1F1F1");
        }
        else{
            $(".filter-block_select-year-wrap span").text("Год");
            $(".filter-block_select-year-wrap").css("background", "#FFF");
        }
    });

    // якорные ссылки
    $("body").on("click",".page_description_show-link, .order-form_description-head a, .note_card-description-links a", function (event) {
        event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 300);
    });

    // note sort
    $("body").on("click", ".filter_choose-sort_head", function() {
        $(this).siblings(".filter_choose-sort_items").toggle();
        return false;
    });

    $("body").on("click", ".filter_choose-sort_item", function() {
        if(!$(this).hasClass("active")) {
            $(this).siblings(".filter_choose-sort_item").removeClass("active");
            $(this).addClass("active").parent().hide();
            $(".filter_choose-sort_head").text($(this).text());
        } else if(!$(this).hasClass("active")) {
            $(this).siblings(".filter_choose-sort_item").removeClass("active");
            $(this).addClass("active")
            $(".filter_choose-sort_head").text($(this).text());
        }
        return false;
    });

    $("body").on("click", function(e) {
        if(!$(".filter_choose-sort_items").is(e.target) && $(".filter__items").has(e.target).length === 0) {
            $(".filter_choose-sort_items").hide();
        }
    });


    //popular notes
     sliderInit();
    $(window).resize(function() {
        sliderInit();
    });

    if($(window).width() < 1250 && $(window).width() > 850) {
        $(".slider__item_wrap").each(function() {
            $(this).css({"margin-right" : ($(".js-slider").width() - $(".js-slider").find(".slider__item_wrap").width()*4)/3  + "px"});
        });

    } else if($(window).width() < 851 && $(window).width() > 730) {
        $(".slider__item_wrap").each(function() {
            $(this).css({"margin-right" : ($(".js-slider").width() - $(".js-slider").find(".slider__item_wrap").width()*3)/2  + "px"});
        });

    }  else {
        $(".slider__item_wrap").each(function() {
            $(this).removeAttr("style");
        });
    }

    $(window).resize(function() {
        if($(window).width() < 1250 && $(window).width() > 850) {
            $(".slider__item_wrap").each(function() {
                $(this).css({"margin-right" : ($(".js-slider").width() - $(".js-slider").find(".slider__item_wrap").width()*4)/3  + "px"});
            });

        } else if($(window).width() < 851 && $(window).width() > 730) {
            $(".slider__item_wrap").each(function() {
                $(this).css({"margin-right" : ($(".js-slider").width() - $(".js-slider").find(".slider__item_wrap").width()*3)/2  + "px"});
            });
        } else {
            $(".slider__item_wrap").each(function() {
                $(this).removeAttr("style");
            });
        }
    });

    $("body").on("click", ".description__block .js-show-all__btn", function() {
        $(this).hide().siblings(".description__block_text").removeClass("fixed-height");
        return false;
    })

    $("body").on("click", ".filter__head", function() {
        $(this).siblings(".filter__items").toggle();
        return false;
    });

    $("body").on("click", ".filter__item", function() {
        if($(window).width() < 769 && !$(this).hasClass("active")) {
            $(this).siblings(".filter__item").removeClass("active");
            $(this).addClass("active").parent().hide();
            $(".filter__head").text($(this).text());
        } else if($(window).width() > 768 && !$(this).hasClass("active")) {
            $(this).siblings(".filter__item").removeClass("active");
            $(this).addClass("active")
            $(".filter__head").text($(this).text());
        }
        return false;
    });

    $("body").on("click", function(e) {
        if(!$(".filter__items").is(e.target) && $(".filter__items").has(e.target).length === 0 && $(window).width() < 769) {
            $(".filter__items").hide();
        }
    });

    $(window).resize(function() {
        if($(this).width() > 768) {
            $(".filter__items").removeAttr("style");
        }
    })

    $("body").on("click", ".popular-notes-wrapper .show-more__btn, .note-artist-wrapper .show-more__btn", function() {
        $(this).hide();
        $(".slider__item").show();
        return false;
    });

    //phone mask
    if ($("#order-phone-input").length > 0) {
        $(function() {
            $.mask.definitions['~'] = "[+-]";
            $("#order-phone-input").mask('+7(999) 999-9999');
        });
    }

    $('body').on('submit', 'form[data-ajax=true]', function(){

        var __this = $(this);
        if(!checkForm(__this)){
            return false;
        }
        var data = __this.serialize();
        data[data.length] = {name: 'ajax', value:'Y'};

        //temp
        //var url = __this[0].action;
        var url =  '/ajax/form.json';
        var host = location.origin + location.pathname.split("/").slice(0, -1).join('/');
        if(__this.data('example') == 'error'){
            url = '/ajax/error.json';
        }
        url = host + url;

        $.ajax({
            method: __this[0].method,
            url: url,
            data: data,
            dataType:'json',
            success: function(answer){
                if(answer.TYPE == 'OK'){
                    __this.remove();
                    $(".js-ok-message").show();
                }
                if (answer.MESSAGE) {
                    showmessage(answer.MESSAGE);
                }
                

            }
        })
        return false;
    });
    // order form validation
    

    //audio player
    if($("audio").length > 0) {
        $( function(){
            $( 'audio' ).audioPlayer();
        });
    }

    //show more card-description
    $("body").on("click", ".note_card-description-showmore", function() { 
        if(!$(this).hasClass('open')){
            $(this).text('Скрыть');
            $(".note_card-description-info_hidden").show();
            $(this).addClass('open');
        }
        else{
            $(this).text('Ещё');
            $(".note_card-description-info_hidden").hide();
            $(this).removeClass('open');
        }
    });

    //note-artist js
    $("body").on("click", ".artist__description .js-show-all__btn", function() {
            $(this).hide().siblings(".hidden").show();
            return false;
        });


        if($('.js-similar__block-slider').length > 0) {
            $('.js-similar__block-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                dots: true,
                variableWidth: true,
                prevArrow: '<div class="slider__arrow_prev"></div>',
                nextArrow: '<div class="slider__arrow_next"></div>',
                responsive: [
                    {
                        breakpoint: 851,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 730,
                        settings: {
                            slidesToShow: 2,
                            variableWidth: false,
                        }
                    },
                    {
                        breakpoint: 581,
                        settings: {
                            slidesToShow: 1,
                            variableWidth: false,
                        }
                    }

                ]
            });
        }

        $("body").on("click", ".product__form .js-add-to-basket__btn", function() {

            var __this = $(this);

            if(__this.hasClass('active')){
                return true;
            }

            // temp
            var url = '/cart/add';


            $.ajax({
                method: "POST",
                url: url,
                data: $('#addCartItem').serialize(),
                dataType:'json',
                success: function(answer){
                    if(answer.TYPE == 'OK'){
                        
                        __this.addClass("active");                        
                        
                        var basketValue = $(".header_middle-info_basket span");
                            basketValue.text(answer.COUNT);
                            if (basketValue.text() > 0){
                                $(".header_middle-info_basket-img").addClass("active");
                        }
                        $.ajax({
                            url: "/cart/count",
                            data: $('#addCartItem').serialize(),
                            method: 'post',
                            dataType:'json',
                            success: function (result) {
                                $('#cartCount').html(result.cartCount);
                            }
                        });
                    }
                    if (answer.MESSAGE){
                        showmessage(answer.MESSAGE);
                    }
                    

                }
            })
              
            return false;

        });

        $("body").on("click", ".remove__btn", function() {
            $(this).parent().remove();
            return false;
        });

        //link to img
         $("body").on("click", ".musical-sets_slider_img, .index_column-item_link img, .note_arrangements-item img, .item__img", function (e) {
            location.href = $(this).siblings("a").attr("href");
        })

        //modal

        $("body").on("click", ".modal_ok-close", function () {
            $(".modal_error-modal").hide();
            return false;
        });

        jQuery(function ($) {
            $(document).mouseup(function (e) {
                if (!$(".modal_content").is(e.target) && $(".modal_content").has(e.target).length === 0) {
                    $(".modal_error-modal").hide();
                }
            });
        });
        

});

function showmessage(msg){
    var modal = $('#modal-note');
    modal.find('.model_conent-message').html(msg);
    modal.show();
}

function sliderInit() {
    if($('.js-notes-slider').length > 0 && !$('.js-notes-slider').hasClass("slick-initialized") && $(window).width() > 530) {
        $('.js-notes-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            variableWidth: true,
            prevArrow: '<div class="slider__arrow_prev"></div>',
            nextArrow: '<div class="slider__arrow_next"></div>',
            responsive: [
                {
                    breakpoint: 851,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 730,
                    settings: {
                        slidesToShow: 2,
                        variableWidth: false,
                    }
                },
                {
                    breakpoint: 581,
                    settings: "unslick"
                }
            ]
        });
    }
}

function checkEmail(emailItem){
    var emailItemValue = emailItem.val();
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{1,3})$/;
    if (!reg.test(emailItemValue)){
        emailItem.addClass("error");
        emailItem.siblings(".order_error-message").show();
        return false;
    }
    else{
        emailItem.removeClass("error");
        emailItem.siblings(".order_error-message").hide();
        return true;
    }

}
