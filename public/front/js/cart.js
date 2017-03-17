    $(".remove").on('click', function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = $(this).attr('product-id');
        var _url = info['destroyUrl'] + '/' + id;
        swal({
            title: '',
            text: info['remove'],
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: info['yes'],
            cancelButtonText: info['no']
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    type: 'DELETE',
                    url: _url,
                    data: {id: id}
                })
                .done(function (data) {
                    _this.parent().parent().remove();
                    $('span.cart-amunt, #sub-total, #total, .nav-cart span').text(data['totalPrice']);
                    $('span.product-count').text(data['totalItems']);
                })
            }
        })
    });
    $(".btn-number").on('click', function () {
        $("input#update-cart").attr('disabled', false);
        var price = $(this).parent().parent().find('.product-price').find('.amount').attr('data-price');
        var quantity = $(this).parent().find('.input-number').val();
        var total = (quantity * price * info['currency_unit']).toLocaleString() + info['currency'];
       $(this).parent().parent().find('.product-subtotal').find('.amount').text(total);
    });
    // update cart
    $("input#update-cart").on('click', function (e) {
        var data = {};
        $("table tr.cart_item").each(function (i, v) {
            data[i] = {
                id: $(this).find('.remove').attr('product-id'),
                quantity: $(this).find('.input-number').val(),
            }
        });
        $.ajax({
            type: 'POST',
            url: info['updateUrl'],
            data: data,
        })
        .done(function (data) {
            $('span.cart-amunt, #sub-total, #total, .nav-cart span').text(data['totalPrice']);
            $('span.product-count').text(data['totalItems']);
            swal('', info['updated'], 'success');
        });
    });
