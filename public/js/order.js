$(function() {
    $(document).on('change', ':checkbox', function() {
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
