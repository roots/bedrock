$('.js_cat-edit').click(function (event) {
    var thisCat = $(this).data('cat');
    event.preventDefault();
    $.ajax(this.href, {
        success: function (data) {
            $('#js_actionDrawer__content').html($(data));






            $('#form-delete-category').submit(function (event) {
                var catName = $(this).find('input[name=catName]').val().replace(/\s+/g, '');
                var formData = {
                    'catName': catName,
                    'thisCat': thisCat
                };
                $.ajax({
                        type: 'POST',
                        url: 'atomic-core/temp-processing/temp-delete-category.php',
                        data: formData,
                        dataType: 'json',
                        encode: true
                    })
                    .done(function (data) {
                        if (!data.success) {
                            if (data.errors.different) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.different + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }
                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }
                        } else {
                            window.location = 'atomic-core/index.php';
                            

                        }
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
                event.preventDefault();
            });




            $('#form-edit-category').find('input[name=catName]').val(thisCat);


            $('#form-edit-category').submit(function (event) {





                var catName = $(this).find('input[name=catName]').val().replace(/\s+/g, '');
                var formData = {
                    'catName': catName,
                    'thisCat': thisCat
                };
                console.log(formData);
                $.ajax({
                        type: 'POST',
                        url: 'atomic-core/temp-processing/temp-edit-category.php',
                        data: formData,
                        dataType: 'json',
                        encode: true
                    })
                    .done(function (data) {
                        if (!data.success) {
                            if (data.errors.different) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.different + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }
                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }
                        } else {
                            window.location = 'atomic-core/?cat='+catName+'';

                        }
                    })
                    .fail(function (data) {
                        console.log(data);
                        console.log('failed');
                    });
                event.preventDefault();
            });
        },
        error: function () {
            //alert('did not worked!');
        }
    });
});