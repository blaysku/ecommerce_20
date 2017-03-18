$(function() {
    // change user status
    $(document).on('change', ':checkbox.user-status', function() {
        $(this).parents('tr').toggleClass('warning');
        $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
        $.ajax({
            url: info['routeUserStatus'] + '/' + this.value,
            type: 'PUT',
            data: 'status=' + this.checked
        })
        .done(function() {
            $('.fa-spin').remove();
            $("input[type='checkbox']:hidden").show();
        })
        .fail(function() {
            $('.fa-spin').remove();
            var chk = $("input[type='checkbox']:hidden");
            chk.show().prop('checked', chk.is(':checked') ? null
                : 'checked').parents('tr').toggleClass('warning');
            swal(info['userFailMsg']);
        });
    });
    //destroy user event
    $('.btn-destroy').on('click',function(e){
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: $(this).attr('data-title'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
        }, function(isConfirm){
            if (isConfirm) form.submit();
        });
    });
    $('#avtive-all, #deactive-all, #destroy-all').on('click', function (e) {
        e.preventDefault();
        var id = [];
        var title = null;
        var status = null;
        var _url = info['changeStatusMulti'];
        $('.select:checked').each(function(i){
          id[i] = $(this).val();
        });
        if ($(this).attr('id') == 'avtive-all') {
            title = info['activeAllUser'];
            status = 1;
        } else if ($(this).attr('id') == 'deactive-all') {
            title = info['deactiveAllUser'];
            status = 0;
        } else {
            title = info['destroyAllUser'];
            _url = info['userDestroyMulti'];
        }
        swal({
            title: title,
            type: 'info',
            showCancelButton: true,
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: _url,
                    type: 'POST',
                    data: {id, status},
                })
                .done(function() {
                    swal(info['successMsg']);
                    location.reload();
                })
                .fail(function(error) {
                    var errors = error.responseJSON;
                    swal(errors[0]);
                })
            }
        });
    });
});
