$('.js-edit-settings').click(function (event) {



    event.preventDefault();
    $.ajax(this.href, {
        success: function (data) {
            $('#js_actionDrawer__content').html($(data));


            var old_compDir = $('#form-edit-settings').find('input[name=compDir]').val();
            var old_compExt = $('#form-edit-settings').find('input[name=compExt]').val();
            var old_stylesExt = $('#form-edit-settings').find('input[name=stylesExt]').val();
            var old_stylesDir = $('#form-edit-settings').find('input[name=stylesDir]').val();


           var currentCat = $('.atomic-h1').text();


            $('#form-edit-settings').submit(function (event) {






                var formData = {
                    'compDir': $(this).find('input[name=compDir]').val(),
                    'compExt': $(this).find('input[name=compExt]').val(),
                    'stylesExt': $(this).find('input[name=stylesExt]').val(),
                    'stylesDir': $(this).find('input[name=stylesDir]').val(),
                    'old_compDir': old_compDir,
                    'old_compExt': old_compExt,
                    'old_stylesExt': old_stylesExt,
                    'old_stylesDir': old_stylesDir
                };






                $.ajax({
                    type: 'POST',
                    url: 'atomic-core/temp-processing/temp-edit-settings.php',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })

                    .done(function (data) {

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


                           window.location = 'atomic-core/?cat='+currentCat+'';
                            
                        }
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
                event.preventDefault();
            });




        },
        error: function () {
            //alert('did not worked!');
        }
    });
});