jQuery(document).ready(function($){

    // jQuery sticky Menu

    $(".mainmenu-area").sticky({topSpacing:0});

    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });

    $('.related-products-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:2,
            },
            1200:{
                items:3,
            }
        }
    });

    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        }
    });


    // Bootstrap Mobile Menu fix
    $(".navbar-nav li a").click(function(){
        $(".navbar-collapse").removeClass('in');
    });

    // jQuery Scroll effect
    $('.navbar-nav li a, .scroll-to-up').bind('click', function(event) {
        var $anchor = $(this);
        var headerH = $('.header-area').outerHeight();
        $('html, body').stop().animate({
            scrollTop : $($anchor.attr('href')).offset().top - headerH + "px"
        }, 1200, 'easeInOutExpo');

        event.preventDefault();
    });

    // Bootstrap ScrollPSY
    $('body').scrollspy({
        target: '.navbar-collapse',
        offset: 95
    })
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.add_to_cart_button, .add-to-cart-link').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        url:  data['addToCartRoute'] + '/' + $(this).attr('product-id'),
        type: 'POST',
        data: {
            quantity: $(this).parent().find('.input-number').val() ? $(this).parent().find('.input-number').val() : 1,
        },
    })
    .done(function(data) {
        $('span.cart-amunt').text(data['totalPrice']);
        $('span.product-count').text(data['totalItems']);
        $("input[name='quantity']").attr('max', data['restAmount']);
    })
    .fail(function(data) {
        var error = data.responseJSON;
        alert(error['error']);
    })
});
