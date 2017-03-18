$(function() {
    $(document).on('change', ':checkbox.order_status', function() {
        $(this).parents('tr').toggleClass('success');
        $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
        var check = this.checked;
        var _this = $(this);
        $.ajax({
            url: data['url'] + '/' + this.value,
            type: 'PUT',
            data: "status=" + check
        })
        .done(function() {
            $('.fa-spin').remove();
            $('input[type="checkbox"]:hidden').show();
            if (!check) {
                _this.parents('tr').find('.status').text(data['waiting']);
            } else {
                _this.parents('tr').find('.status').text(data['done']);
            }
        })
        .fail(function() {
            $('.fa-spin').remove();
            var chk = $('input[type="checkbox"]:hidden');
            chk.show().prop('checked', chk.is(':checked') ? null : 'checked').parents('tr').toggleClass('success');
            swal(data['fail']);
        });
    });
});
$('#all-done, #all-waiting').on('click', function (e) {
    e.preventDefault();
    var id = [];
    var title = null;
    var status = null;
    $('.select:checked').each(function(i){
      id[i] = $(this).val();
    });
    if ($(this).attr('id') == 'all-done') {
        title = data['paid'];
        status = 1;
    } else {
        title = data['notPaid'];
        status = 0;
    }
    swal({
        title: title,
        type: "info",
        showCancelButton: true,
    }, function(isConfirm){
        if (isConfirm) {
            $.ajax({
                url: data['updateMultiUrl'],
                type: 'POST',
                data: {id, status},
            })
            .done(function() {
                swal('Succesfully');
                location.reload();
            })
            .fail(function(error) {
                var errors = error.responseJSON;
                swal(errors[0]);
            })
        }
    });
});
