//select all checkboxes
$('#selectall').on('change', function(){
    var status = this.checked;
    $('.select').each(function(){
        this.checked = status;
    });
    $('.selected').attr('disabled', !this.checked);
});

$('.select').change(function(){

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
