
(function ($) {
    "use strict";

    /*[ Load page ]
    ===========================================================*/
    $(".animsition").animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 1500,
        outDuration: 800,
        linkElement: '.animsition-link',
        loading: true,
        loadingParentElement: 'html',
        loadingClass: 'animsition-loading-1',
        loadingInner: '<div data-loader="ball-scale"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: [ 'animation-duration', '-webkit-animation-duration'],
        overlay : false,
        overlayClass : 'animsition-overlay-slide',
        overlayParentElement : 'html',
        transition: function(url){ window.location.href = url; }
    });
    
    /*[ Back to top ]
    ===========================================================*/
    var windowH = $(window).height()/2;

    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css('display','flex');
        } else {
            $("#myBtn").css('display','none');
        }
    });

    $('#myBtn').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 300);
    });


    /*[ Show header dropdown ]
    ===========================================================*/
    $('.js-show-header-dropdown').on('click', function(){
        $(this).parent().find('.header-dropdown');
        if($('.js-show-login-popup').parent().find('.login-dropdown').hasClass('show-login-popup')){
            $('.js-show-login-popup').parent().find('.login-dropdown').toggleClass('show-login-popup');
        }
    });

    var menu = $('.js-show-header-dropdown');
    var sub_menu_is_showed = -1;

    for(var i=0; i<menu.length; i++){
        $(menu[i]).on('click', function(){ 
            
                if(jQuery.inArray( this, menu ) == sub_menu_is_showed){
                    $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
                    sub_menu_is_showed = -1;
                }
                else {
                    for (var i = 0; i < menu.length; i++) {
                        $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
                    }

                    $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
                    sub_menu_is_showed = jQuery.inArray( this, menu );
                }
        });
    }

    $(".js-show-header-dropdown, .header-dropdown").click(function(event){
        event.stopPropagation();
    });

    $(window).on("click", function(){
        for (var i = 0; i < menu.length; i++) {
            $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
        }
        sub_menu_is_showed = -1;
    });


    /*[ Show login dropdown ]
    ===========================================================*/
    $('.js-show-login-popup').on('click', function(){
        $(this).parent().find('.login-dropdown').toggleClass('show-login-popup');
    });


     /*[ Fixed Header ]
    ===========================================================*/
    var posWrapHeader = $('.topbar').height();
    var header = $('.container-menu-header');

    $(window).on('scroll',function(){

        if($(this).scrollTop() >= posWrapHeader) {
            $('.header1').addClass('fixed-header');
            $(header).css('top',-posWrapHeader); 

        }  
        else {
            var x = - $(this).scrollTop(); 
            $(header).css('top',x); 
            $('.header1').removeClass('fixed-header');
        } 

        if($(this).scrollTop() >= 200 && $(window).width() > 992) {
            $('.fixed-header2').addClass('show-fixed-header2');
            $('.header2').css('visibility','hidden'); 
            $('.header2').find('.header-dropdown').removeClass("show-header-dropdown");
            
        }  
        else {
            $('.fixed-header2').removeClass('show-fixed-header2');
            $('.header2').css('visibility','visible'); 
            $('.fixed-header2').find('.header-dropdown').removeClass("show-header-dropdown");
        } 

    });
    
    /*[ Show menu mobile ]
    ===========================================================*/
    $('.btn-show-menu-mobile').on('click', function(){
        $(this).toggleClass('is-active');
        $('.wrap-side-menu').slideToggle();
    });

    var arrowMainMenu = $('.arrow-main-menu');

    for(var i=0; i<arrowMainMenu.length; i++){
        $(arrowMainMenu[i]).on('click', function(){
            $(this).parent().find('.sub-menu').slideToggle();
            $(this).toggleClass('turn-arrow');
        })
    }

    $(window).resize(function(){
        if($(window).width() >= 992){
            if($('.wrap-side-menu').css('display') == 'block'){
                $('.wrap-side-menu').css('display','none');
                $('.btn-show-menu-mobile').toggleClass('is-active');
            }
            if($('.sub-menu').css('display') == 'block'){
                $('.sub-menu').css('display','none');
                $('.arrow-main-menu').removeClass('turn-arrow');
            }
        }
    });


    /*[ remove top noti ]
    ===========================================================*/
    $('.btn-romove-top-noti').on('click', function(){
        $(this).parent().remove();
    })


    /*[ Block2 button wishlist ]
    ===========================================================*/
    $('.block2-btn-addwishlist').on('click', function(e){
        e.preventDefault();
        $(this).addClass('block2-btn-towishlist');
        $(this).removeClass('block2-btn-addwishlist');
        $(this).off('click');
    });

    /*[ +/- num product ]
    ===========================================================*/
    $('.btn-num-product-down').on('click', function(e){
        e.preventDefault();
        var numProduct = Number($(this).next().val());
        if(numProduct > 1) $(this).next().val(numProduct - 1);
    });

    $('.btn-num-product-up').on('click', function(e){
        e.preventDefault();
        var numProduct = Number($(this).prev().val());
        $(this).prev().val(numProduct + 1);
    });


    /*[ Show content Product detail ]
    ===========================================================*/
    $('.active-dropdown-content .js-toggle-dropdown-content').toggleClass('show-dropdown-content');
    $('.active-dropdown-content .dropdown-content').slideToggle('fast');

    $('.js-toggle-dropdown-content').on('click', function(){
        $(this).toggleClass('show-dropdown-content');
        $(this).parent().find('.dropdown-content').slideToggle('fast');
    });


    /*[ Play video 01]
    ===========================================================*/
    var srcOld = $('.video-mo-01').children('iframe').attr('src');

    $('[data-target="#modal-video-01"]').on('click',function(){
        $('.video-mo-01').children('iframe')[0].src += "&autoplay=1";

        setTimeout(function(){
            $('.video-mo-01').css('opacity','1');
        },300);      
    });

    $('[data-dismiss="modal"]').on('click',function(){
        $('.video-mo-01').children('iframe')[0].src = srcOld;
        $('.video-mo-01').css('opacity','0');
    });


    /*[ Dropdown selection ]
    ===========================================================*/
    $(".selection-1").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect2')
    });

    //buat search aloglia

    var client = algoliasearch('TP8H76V4RK', '2301f1d5e0f4569f9820e31d870e1aab');
    var index = client.initIndex('team_product');
    //initialize autocomplete on search input (ID selector must match)
    $('#aa-search-input').autocomplete({
        hint: false
    }, [{
        source: $.fn.autocomplete.sources.hits(index, {
            hitsPerPage: 5
        }),
        //value to be displayed in input control after user's suggestion selection
        displayKey: 'name',
        //hash of templates used when rendering dataset
        templates: {
            //'suggestion' templating function used to render a single suggestion
            suggestion: function (suggestion) {
                // return '<span>' + suggestion._highlightResult.firstname.value + '</span><span>' + suggestion._highlightResult.lastname.value + '</span>';
                return '<span>' + suggestion._highlightResult.name.value + '</span>';
            }
        }
    }]).on('autocomplete:selected', function (event, suggestion, dataset) {
        window.location.href = '/product' + suggestion.slug;
        console.log(suggestion);
    });

    if ($('#payment_method_balance').is(':checked')) {
        $('#cc').hide();
        $('#cek_payment').val('true');
    }

    $('#cvc').change(function (e) {
        var id;
        Stripe.card.createToken({
            number: $('#card').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#month').val(),
            exp_year: $('#year').val()
        }, function (status, response) {

            if (response.error) { // Problem!

                swal({
                    title: "Error Payment !",
                    text: response.error.message,
                    // timer: 3000,
                    showConfirmButton: true,
                    icon: "error",
                });

                $('#card').val('');
                $('#cvc').val('');
                $('#month').val('');
                $('#year').val('');

                 $('#cek_payment').val('false');
                

            } else { // Token was created!

                 $('#cek_payment').val('true');
                //$('#payment').append('<input type="hidden" value="' + response.id + '" name="stripeToken">');
            }
        });
        return false;
    });

    /*[ Payment method selection ]
    ===========================================================*/
    $(function () {
        $('#payment_method_paypal').click(function () {
            if ($(this).is(':checked')) {
                $('#cc').hide(1000);
                $('#cek_payment').val('true');
            }
        });
        $('#payment_method_balance').click(function () {
            if ($(this).is(':checked')) {
                $('#cc').hide(1000);
                 $('#cek_payment').val('true');
            }
        });
        $('#payment_method_cc').click(function () {
            if ($(this).is(':checked')) {
                $('#cc').show(1000);
                 $('#cek_payment').val('false');
            }
        });
    });

        $(document).ready(function () {
            $('#form-payment').submit(function (e) {

                var id;
                Stripe.card.createToken({
                    number: $('#card').val(),
                    cvc: $('#cvc').val(),
                    exp_month: $('#month').val(),
                    exp_year: $('#year').val()
                }, function (status, response) {

                    if (response.error) { // Problem!

                        swal({
                            title: "Error Payment !",
                            text: response.error.message,
                            // timer: 3000,
                            showConfirmButton: true,
                            icon: "error",
                        });

                        $('#card').val('');
                        $('#cvc').val('');
                        $('#month').val('');
                        $('#year').val('');

                        $('#cek_payment').val('false');
                         e.preventDefault(); // to stop form submitting


                    } else { // Token was created!

                        $('#cek_payment').val('true');
                        $('#form-payment').submit();
                        //$('#payment').append('<input type="hidden" value="' + response.id + '" name="stripeToken">');
                    }
                });

                var cek = $('#cek_payment').val();
                if(cek == 'false'){
                    
                    e.preventDefault(); // to stop form submitting
                }
                else{
                      $('#form-payment').submit();
                }
            });
        });


    /*[ Shipping Checkbox selection ]
    ===========================================================*/
    $(".input-shipping-option").change(function() {
        if(this.checked) {
            $('#shipping-process').slideDown(300);
        }
        else {
            $('#shipping-process').slideUp(300);
        }
    });

    /*[ Purchase Detail ]
    ===========================================================*/
    $('.action_detail').click(function() {
        var invoice = $(this).attr('rel');
        $('.detail-item').slideUp();
        // console.log(invoice);
        if($('tr.' + invoice).is(':visible')){
            $('tr.' + invoice).slideUp(300);
        }else{
            $('tr.' + invoice).slideDown(300);
        }
    });

})(jQuery);

function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document.body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document.body.scrollWidth;
    }

    document.getElementById(id).height=(newheight) + "px";
    document.getElementById(id).width=(newwidth) + "px"; 
}


