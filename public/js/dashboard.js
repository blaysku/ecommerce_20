$(function() {
    function requestData(days, chart) {
        $.ajax({
                type: 'GET',
                dataType: 'json',
                url: info['statsUrl'],
                data: {
                    days: days
                }
            })
            .done(function(data) {
                chart.setData(data);
            })
            .fail(function() {
                alert(info['error']);
            });
    }
    var chart = Morris.Bar({
        element: 'stats-container',
        data: [0, 0],
        xkey: 'date',
        ykeys: ['value'],
        labels: ['Orders'],
        resize: true
    });
    requestData(7, chart);
    $('ul.ranges a').click(function(e) {
        e.preventDefault();
        var el = $(this);
        days = el.attr('data-range');
        el.parents('ul').find('li').removeClass('active');
        el.parent().addClass('active');
        requestData(days, chart);
    })
});
