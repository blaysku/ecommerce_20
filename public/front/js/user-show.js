$('.success, .warning').find('.cancel-order').attr('disabled', true);

$('#submit-update').click(function() {
    $.ajax({
        url: info['userUpdateUrl'],
        data: new FormData($("#update-user")[0]),
        dataType: 'json',
        async: false,
        type: 'POST',
        processData: false,
        contentType: false,
    })
    .done(function(data) {
        swal({
            title: '',
            text: info['successMsg'],
            type: 'success',
        }, function(isConfirm) {
            if (isConfirm) {
                location.reload();
            }
        })
    })
    .fail(function(data) {
        var errors = data.responseJSON;
        $('.form-group').removeClass('has-error').find('small').empty();
        $.each(errors, function(index, error) {
            $('#' + index).parents('.form-group').addClass('has-error').find('small').text(error[0]);
        });
    });
});

$('.order-table').hide();
$('.see-order').on('click', function(e) {
    e.preventDefault();
    $('.order-table').toggle('slow');
});

$('.cancel-order').on('click', function(e) {
    var _this = $(this);
    e.preventDefault();
    swal({
        title: '',
        text: info['cancelMsg'],
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: info['yes'],
        cancelButtonText: info['no']
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: info['orderUpdateUrl'] + '/' + _this.attr('data-order-id'),
                method: 'PUT',
            })
            .done(function() {
                _this.attr('disabled', true).parents('tr').addClass('warning').find('.order-status').text(info['cancel']);
            });
        }
    })
});
