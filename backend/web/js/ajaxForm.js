$(document).on('beforeSubmit', "#staff", function (event) {
        event.preventDefault(); // avoid to execute the actual submit of the form.

        let form = $(this);
        let data = form.serialize();
        let url = form.attr('action');

       //console.log(url);
           /*$.ajaxSetup({
                headers : {
                    'CSRFToken' : $("meta[name='csrf-token']").attr('content')
                }
            });*/
    //alert('1: ' + $("meta[name='csrf-token']").attr('content'));
    //console.log('1: ' + $("meta[name='csrf-token']").attr('content'));
    //console.log('2: ' + $("[name='_csrf-backend']").val());
        $.ajax({
            async: true,
            //crossDomain: true,
            url: url,
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            cache: false,
            //processData: false,
            data: data,
            type: 'POST',
            headers: {
                'X-CSRFToken': $("meta[name='csrf-token']").attr('content')
            },
            //_csrfna
            //_csrf: $("meta[name='csrf-token']").attr('content'),
            beforeSend: function(request){
                //console.log(data);
                //return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(success){

               //console.log('success: ' + success);
                $('#addStaffFormModel').modal('hide');
                //console.log(res);
                //$('#addStaffFormModel').modal('hide');
            },
            complete: function() {
            },
            error: function (error) {
                let str = "";
                for(let k in error) {
                    str += k+": "+ error[k]+"\r\n";
                }

                //console.log('error: ' + str);
                //toastr.warning("","There may a error on uploading. Try again later");
            }

        });
        return false;

});