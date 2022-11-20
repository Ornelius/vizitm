$(document).on('click', '.commentForm', function () {
    $('#idComments').modal('show').find('.modal-dialog').load($(this).attr('href'));
})