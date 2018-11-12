$('.atomic-editorWrap').submit(function (event) {



    event.preventDefault();


    var compName = $(this).data('editorformcomp');
    var catName = $(this).data('editorformcat');
    var hasjs = $(this).closest('.compWrap').data('hasjs');


    var newMarkupCode = $(this).closest('.tab-content').find("input[name=new-markup-val-"+compName+"]").val();
    var newStylesCode = $(this).closest('.tab-content').find("input[name=new-styles-val-"+compName+"]").val();



    if(hasjs == true){
        var newJsCode = $(this).closest('.tab-content').find("input[name=new-js-val-"+compName+"]").val();
    }
    if(hasjs == false){
        var newJsCode = "noJs";
    }








    var formData = {
        'compName': compName,
        'catName': catName,
        'newMarkupCode': newMarkupCode,
        'newStylesCode': newStylesCode,
        'newJsCode': newJsCode
    };

    $.ajax({
            type: 'POST',
            url: 'atomic-core/temp-processing/temp-editor.php',
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function (data) {
            console.log(data);
            if (!data.success) {


                console.log('not success');



                if (data.errors.name) {
                    $('.aa_errorBox__message').html("");
                    $('.atoms-main').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                }

            } else {



                $('.se-pre-con').fadeIn('slow');

                setTimeout(function() {
                  window.location = 'atomic-core/?cat='+catName;
                }, 2000);
            }
        })
        .fail(function (data) {
            console.log('failed');
            console.log(data);
        });
    event.preventDefault();
});

