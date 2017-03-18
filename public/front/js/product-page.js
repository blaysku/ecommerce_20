$("#price").slider({
    ticks: [0, 1000, 2000, 5000, 10000],
    ticks_positions: [0, 10, 20, 50, 100],
    ticks_labels: ['0', '1m', '2m', '5m', '10m'],
    ticks_snap_bounds: 30,
    range: true,
    value : data['value'],
});
$('#filter').submit(function (e) {
    e.preventDefault();
    $.get($(this).attr('action'), {
        category: $("select#category").val(),
        price: $("#price").val(),
        orderby: $('#orderby').val(),
        direction: $("#direction").val(),
    })
    .done(function(data) {
        $('#data').html(data.view);
        $('.link').html(data.links);
    })
    .fail(function() {
        swal(data['error']);
    });
});
var config = {
    toolbar : [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
    ]
};
CKEDITOR.replace( 'description', config);
$('#submit').click(function() {
    var formData = new FormData($("#suggest-data")[0]);
    formData.set('description', CKEDITOR.instances.description.getData());
    $.ajax({
        url: data['suggestUrl'],
        data: formData,
        dataType: 'json',
        async: false,
        type: 'POST',
        processData: false,
        contentType: false,
    })
    .done(function() {
        swal({
            title: '',
            text: data['successMsg'],
            type: 'success',
        });
    })
    .fail(function(data) {
        var errors = data.responseJSON;
        $('.form-group').removeClass('has-error').find('small').empty();
        $.each(errors, function(index, error) {
            $('#' + index).parents('.form-group').addClass('has-error').find('small').text(error[0]);
        });
    });
});
