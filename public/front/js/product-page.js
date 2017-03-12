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
