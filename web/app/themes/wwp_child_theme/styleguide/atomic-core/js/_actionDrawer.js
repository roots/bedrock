//action drawer.js


$('.aa_fileSection__file .aa_actionBtn').click(function (event) {


    event.preventDefault();
    $.ajax(this.href, {
        success: function (data) {
            $('#js_actionDrawer__content').html($(data));

            //Rotates plus icon for edit component forms
            $('.js-showHide-trigger').click(function () {

                $('.showHide').slideUp(250);
                $('.fa-plus').removeClass('fa-plus-is-rotated');

                if ($(this).next().is(':hidden')) {
                    $(this).next().slideDown(250);
                    $(this).find('.fa-plus').addClass('fa-plus-is-rotated');
                }
            });


            //Initialize color picker
            $(".bgColor").spectrum({
                allowEmpty: true,
                preferredFormat: "hex",
                showInput: true,
                //showAlpha: true
            });

            //Submits rename file data
            $('#form-rename-file').submit(function (event) {
                reDirect = $('input[name=compDir]').val();
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'oldName': $('input[name=oldName]').val(),
                    'renameFileName': $('input[name=renameFileName]').val(),
                    'compNotes': $('input[name=compNotes]').val(),
                    'bgColor': $('input[name=bgColor]').val(),
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/file-rename.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {

                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


            //put notes value in compNotes hidden field
            notesTarget = $('input[name=fileMoveName]').val();
            notesContent = $('.atoms-main #' + notesTarget).next().text();


            $('input[name=compNotes]').val(notesContent);


            /*colorContent = $('#'+colorTarget).parent().find('.component').css('background-color');*/


            //Sets the hidden field value for the current bgColor

            colorTarget = $('input[name=fileMoveName]').val();

            colorContent = $('#' + colorTarget).parent().find('.component').attr("style");
            console.log(colorContent);
            colorContent = colorContent.split(":").pop();
            colorContent.slice(0, -1);
            $('input[name=bgColor]').val(colorContent);


            //check what is the current category and remove from select
            dirVal = $('#form-file-move input[name=compDir]').val();

            console.log(dirVal);

            $("#newDir option[value=" + dirVal + "]").remove();

            dirCount = $('#newDir option').size();

            if (dirCount < 1) {
                //$('#form-file-move').remove();
                $('#form-file-move').parent().html('There are no catgories to move to at this time.');
            }

            //Submits move file data
            $('#form-file-move').submit(function (event) {
                reDirect = $('#newDir').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'newDir': $('#newDir').val(),
                    'fileMoveName': $('input[name=fileMoveName]').val(),
                    'compNotes': $('input[name=compNotes]').val(),
                    'bgColor': $('input[name=bgColor]').val(),

                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/file-move.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------

                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {



                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


            $('#form-delete-file').submit(function (event) {
                reDirect = $('input[name=compDir]').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'deleteFileName': $('input[name=deleteFileName]').val(),
                    'compNotes': $('input[name=compNotes]').val(),
                    'bgColor': $('input[name=bgColor]').val()
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/delete.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------

                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {


                            //alert(reDirect);
                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


            notesEditTarget = $('input[name=fileName]').val();
            notesEditTarget = $('.atoms-main #' + notesTarget).next().text();

            //alert(notesEditTarget);


            $('textarea[name=compNotesNew]').val(notesEditTarget);

            //Submits rename notes data
            $('#form-rename-notes').submit(function (event) {

                notesEditTarget = $('input[name=fileName]').val();
                notesEditTarget = $('.atoms-main #' + notesTarget).next().text();

                $('input[name=compNotes]').val(notesEditTarget);
                reDirect = $('input[name=compDir]').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'fileName': $('input[name=fileName]').val(),
                    'bgColor': $('input[name=bgColor]').val(),
                    'compNotes': $('input[name=compNotes]').val(),
                    'compNotesNew': $('textarea[name=compNotesNew]').val()
                };


                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/notes-rename.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {

                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


            colorTarget = $('input[name=fileMoveName]').val();


            //Submits change background color data
            $('#form-change-bgColor').submit(function (event) {

                reDirect = $('input[name=compDir]').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'fileName': $('input[name=fileName]').val(),
                    'compNotes': $('input[name=compNotes]').val(),
                    'bgColor': $('input[name=bgColor]').val(),
                    'bgColorNew': $('input[name=bgColorNew]').val(),
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/bgcolor-rename.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {

                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


        },
        error: function () {
            //alert('did not worked!');
        }
    });
});




$('.aa_addFileItem .aa_actionBtn').click(function (event) {


    event.preventDefault();
    $.ajax(this.href, {
        success: function (data) {
            $('#js_actionDrawer__content').html($(data));

            //Initialize color picker
            $(".bgColor").spectrum({
                allowEmpty: true,
                preferredFormat: "hex",
                showInput: true,
                //showAlpha: true
            });

            //Submits create file data
            $('#form-create-file').submit(function (event) {
                reDirect = $('input[name=compDir]').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'compDir': $('input[name=compDir]').val(),
                    'fileCreateName': $('input[name=fileCreateName]').val(),
                    'compNotes': $('textarea[name=compNotes]').val(),
                    'bgColor': $('input[name=bgColor]').val()
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/create.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {

                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


        },
        error: function () {
            //alert('did not worked!');
        }
    });
});



$('.catAdd .aa_actionBtn').click(function (event) {


    event.preventDefault();
    $.ajax(this.href, {
        success: function (data) {
            $('#js_actionDrawer__content').html($(data));


            //Submits create category data
            $('#form-create-category').submit(function (event) {
                reDirect = $('input[name=dirName]').val();
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'dirName': $('input[name=dirName]').val()
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/create-category.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {

                            //redirect here
                            window.location = 'atomic-core/' + reDirect + '.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });

            //Submits delete category data
            $('#form-delete-category').submit(function (event) {
                // remove the error text
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'dirName': $('input[name=inputNameDelete]').val()
                };
                // process the form
                $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'atomic-core/partial-mngr/delete-category.php', // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function (data) {
                        // log data to the console so we can see
                        console.log(data);
                        // here we will handle errors and validation messages
                        if (!data.success) {
                            // handle errors for name ---------------


                            if (data.errors.exists) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                            if (data.errors.name) {
                                $('.aa_errorBox__message').html("");
                                $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                            }


                        } else {
                            //redirect here
                            window.location = 'atomic-core/index.php';
                            // usually after form submission, you'll want to redirect
                        }
                    })
                    // using the fail promise callback
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log(data);
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


        },
        error: function () {
            //alert('did not worked!');
        }
    });
});