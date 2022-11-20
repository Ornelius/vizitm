$(function() {

    $(this).hover(function (){
        var str = "";
        str = $('.file-error-message').text();
        if(str.length) {
            $("#submitButton").prop("disabled", true);
        } else {
            $("#submitButton").removeAttr('disabled');
        }
    });
    $('#photocreateform-files').hover(function (){

        var str = "";
        str = $('.file-error-message').text();
        $(document).mousemove(function (){
            if(str.length) {
                $("#submitButton").prop("disabled", true);
            } else {
                $("#submitButton").removeAttr('disabled');
            }
        });
        if(str.length) {
            $("#submitButton").prop("disabled", true);
        } else {
            $("#submitButton").removeAttr('disabled');
        }

    });
   /* $("#submitButton").on('mouseup',function() {
        var str = "";
        str = $('.file-error-message').text();
        if(str.length) {
            $("#submitButton").prop("disabled", true);
        }


    });*/

    //Необходимо создать функция, котороя получает значение с поля описание и поля help-block

   // $(".help-block").on('click',function(){
   //     console.log( $(this).text() );

   // }, false)

});