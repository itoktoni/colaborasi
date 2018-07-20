$('#link').click(function (data) {
    var like = $(this).attr('data');
    var product = $(this).attr('href').replace("#", '');

    $.ajax({
        type: 'POST',
        data: {
            value: like,
            product: product
        },
        success: function (data) {

           if(data == 'error'){
                swal({
                    title: "Error Love !",
                    text: 'You Must Login First !',
                    // timer: 3000,
                    showConfirmButton: true,
                    icon: "error",
                });
           } 
           
           if (data == "1") {
               $('#link').attr('data', '1');
               $('#link').removeAttr('style').css('background-color', 'lightgrey');
               $('#love').removeAttr('style').css('color', 'red');

           } else {

               $('#link').attr('data', '0');
               $('#link').removeAttr('style').css('background-color', 'black');
               $('#love').removeAttr('style').css('color', 'white');
           }
        }
    });

    return false;

});
