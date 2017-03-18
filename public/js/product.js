$(function() {
    // change user status
    $(document).on('change', ':checkbox.product-status', function() {
        $(this).parents('tr').toggleClass('warning');
        $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
        $.ajax({
            url: data['url'] + '/' + this.value,
            type: 'PUT',
            data: "trending=" + this.checked
        })
        .done(function() {
            $('.fa-spin').remove();
            $('input[type="checkbox"]:hidden').show();
        })
        .fail(function() {
            $('.fa-spin').remove();
            var chk = $('input[type="checkbox"]:hidden');
            chk.show().prop('checked', chk.is(':checked') ? null : 'checked').parents('tr').toggleClass('warning');
            swal(data['fail']);
        });
    });
    //destroy user event
    $('.btn-destroy').on('click',function(e){
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: $(this).attr('data-title'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: data['yes'],
            cancelButtonText: data['no']
        }, function(isConfirm){
            if (isConfirm) form.submit();
        });
    });
});
$('.page-header #import').on('click', function(e) {
    e.preventDefault();
    swal({
        title: data['importMsg'],
        showCancelButton: true,
        confirmButtonText: data['yes'],
        cancelButtonText: data['no']
    }, function(isConfirm){
        if (isConfirm)
            window.location.href = $('.page-header a').attr('href');
    });
})
$('#destroy-all').on('click', function (e) {
    e.preventDefault();
    var id = [];
    $('.select:checked').each(function(i){
      id[i] = $(this).val();
    });
    swal({
        title: data['deleteAll'],
        type: 'warning',
        showCancelButton: true,
    }, function(isConfirm){
        if (isConfirm) {
            $.ajax({
                url: data['destroy_all'],
                type: 'POST',
                data: {id},
            })
            .done(function() {
                swal(data['successMsg']);
                location.reload();
            })
            .fail(function(error) {
                var errors = error.responseJSON;
                swal(errors[0]);
            })
        }
    });
});
