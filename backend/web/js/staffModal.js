$(document).on('click', '.staffForm', function () {
    $('#addStaffFormModel').modal('show').find('.modal-dialog').load($(this).attr('href'));
})