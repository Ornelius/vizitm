$(document).on('click', '.staffForm', function () {
    console.log('asdfasdasd');
    $('#addStaffFormModel').modal('show').find('.modal-dialog').load($(this).attr('href'));
})