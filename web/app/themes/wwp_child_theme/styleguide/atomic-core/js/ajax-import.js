//Submits create file data
$('#importForm').submit(function (event) {
    var formData = {
        'catName': 'import'
    };

    $.ajax({
            type: 'POST',
            url: 'atomic-core/temp-processing/temp-import.php',
            data: formData,
            dataType: 'json',
            encode: true

        })
        .done(function (data) {
            console.log(data);
            if (!data.success) {
                if (data.errors.exists) {
                    $('.aa_errorBox__message').html("");
                    $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                }


                if (data.errors.name) {
                    $('.aa_errorBox__message').html("");
                    $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                }


            } else {

                    //alert(data.message);

                $('.aa_errorBox__message').html("");
                $('body').prepend('<div class="aa_errorBox aa_errorBox-pos"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.message + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);

                
                //window.location = 'atomic-core/?cat=' + catName + '';
            }
        })
        .fail(function (data) {
            console.log(data);
        });
    event.preventDefault();
});
