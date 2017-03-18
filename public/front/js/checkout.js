$('#diff-check').on('change', function() {
    $('input[type="text"]').empty().attr('disabled', !this.checked);
})

$('#place_order').on('click', function(e) {
    e.preventDefault();
    swal('', info['waitingMsg']);
    $.ajax({
            url: info['checkoutUrl'],
            type: 'POST',
            data: $('#customer-info').serialize(),
        })
        .done(function(data) {
            swal({
                title: '',
                text: info['successMsg'],
                type: 'success',
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = info['redirectUrl'];
                }
            })
        })
        .fail(function(data) {
            var errors = data.responseJSON;
            $('.customer-address, .customer-name, .customer-phone').removeClass('has-error').find('small').empty();

            if (errors['name']) {
                $('.customer-name').addClass('has-error').find('small').text(errors['name'][0]);
            }

            if (errors['phone']) {
                $('.customer-phone').addClass('has-error').find('small').text(errors['phone'][0]);
            }

            if (errors['address']) {
                $('.customer-address').addClass('has-error').find('small').text(errors['address'][0]);
            }
        });
})
