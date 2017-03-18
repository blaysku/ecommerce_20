if ($('.select:disabled').length == $('.select').length) {
    $('input#selectall').attr('disabled', true);
}

$('#selectall').on('change', function(){
    var status = this.checked;
    $('.select:enabled').each(function(){
        this.checked = status;
    });
    $('.selected').attr('disabled', !this.checked);
});

$('.select:enabled').change(function(){

    if ($('.select:checked').length == $('.select:enabled').length) {
        $('input#selectall').prop('checked', true);
    }

    if(this.checked == false){
        $('input#selectall').prop('checked', false);
    }

    if ($('.select:checked').length == $('.select').length){
        $('input#selectall').prop('checked', true);
    }

    var val = [];
    $('.select:checked').each(function(i){
      val[i] = $(this).val();
    });

    if (val.length > 0) {
        $('.selected').attr('disabled', false);
    } else {
        $('.selected').attr('disabled', true);
    }
});


$('#destroy-all').on('click', function (e) {
    e.preventDefault();
    var id = [];
    $('.select:checked').each(function(i){
      id[i] = $(this).val();
    });
    swal({
        title: 'Reject all selected item?',
        type: "warning",
        showCancelButton: true,
    }, function(isConfirm){
        if (isConfirm) {
            $.ajax({
                url: data['rejectAllUrl'],
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
