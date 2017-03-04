$(".delete").on('click', function (e) {
    var form = $(this).siblings('form');
    swal({
        title: trans['title'] +' '+ $(this).attr('data-name-value') + '?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: trans['yes'],
        cancelButtonText: trans['no']
    },
    function(isConfirm){
      if(isConfirm) form.submit();
    });
});
$('#tree').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
