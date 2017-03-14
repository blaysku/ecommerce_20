var config = {
    toolbar : [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
    ]
};

CKEDITOR.replace( 'review', config);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var review = data['review'];
var _url = data['routeStore'];
var type = 'POST';

if (review) {
    $("#edit").hide();
}

$("#edit-review").on('click', function(e) {
    e.preventDefault();
    $("#edit").show();
    $("#review-content").hide();
    _url = data['routeUpdate'];
    type = 'PUT';
});

$('#review-submit').on('click', function() {
    $.ajax({
        url: _url,
        type: type,
        data: {
            rating: $("#rating").rateit('value'),
            review: CKEDITOR.instances.review.getData(),
            product_id: data['productId'],
            user_id: data['userId'],
        },
    })
    .done(function(data) {
        $(".rating, .review").removeClass('text-danger').find("p").empty();
        $("#edit").hide();
        $("#review-content").show().find("#content").html(data[0]);
    })
    .fail(function(data) {
        var errors = data.responseJSON;
        $(".rating, .review").removeClass('text-danger').find("p").empty();

        if (errors['rating']) {
            $(".rating").addClass('text-danger').find("p").text(errors['rating'][0]);
        }

        if (errors['review']) {
            $(".review").addClass('text-danger').find("p").text(errors['review'][0]);
        }
    });
});
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').on('click', function(e) {
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
});
