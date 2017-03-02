$('#logout').click(function(e) {
    e.preventDefault();
    $('#logout-form').submit();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
