    $(".remove").on('click', function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = $(this).attr('product-id');
        var _url = info['destroyUrl'] + '/' + id;
        $.ajax({
            type: 'DELETE',
            url: _url,
            data: {id: id}
        })
        .done(function (data) {
            _this.parent().parent().remove();
            $('span.cart-amunt, #sub-total, #total').text(data['totalPrice']);
            $('span.product-count').text(data['totalItems']);
        })
    });
    $(".btn-number").on('click', function () {
        $("input#update-cart").attr('disabled', false);
        var price = $(this).parent().parent().find('.product-price').find('.amount').attr('data-price');
        var quantity = $(this).parent().find('.input-number').val();

        if ($(this).attr('data-type') == 'minus') {
            quantity -= 1;
        } else if ($(this).attr('data-type') == 'plus') {
            quantity = Number(quantity) + 1;
        }

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
            $('span.cart-amunt, #sub-total, #total').text(data['totalPrice']);
            $('span.product-count').text(data['totalItems']);
        });
    });
