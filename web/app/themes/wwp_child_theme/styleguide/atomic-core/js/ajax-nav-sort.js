$('.editorMode').find(".atoms-nav ").sortable({
    group: ".aa_dir ",
    handle: ".aa_dir__dirNameGroup__name",
    onEnd: function (evt) {
        var itemEl = evt.item;  // dragged HTMLElement
        var catName = $(itemEl).closest('.aa_dir').data("navitem");


        var formData = [];
        $(".atoms-nav ").find('.aa_dir').each(function () {



            formData.push({
                name:'catName[]',
                value:$(this).data("navitem"),
            });
        });
        $.ajax({
                type: 'POST',
                url: 'atomic-core/temp-processing/temp-nav-cat-sort.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
            .done(function (data) {
                console.log(data);
                if (!data.success) {
                    console.log('not success');
                    if (data.errors.name) {
                        //do error stuff
                    }
                } else {
                    console.log('success');
                    window.location = 'atomic-core/?cat='+catName+'';
                }
            })
            .fail(function (data) {
                console.log('failed');
            });

    }
});




$('.editorMode').find(".aa_fileSection").sortable({
    group: ".aa_fileSection ",
    filter: ".aa_addFileItem",

    onUpdate: function (evt) {
        var itemEl = evt.item;
        var currentCat = $(itemEl).data("cat");
        var formData = [];

        $(".fileSection-"+currentCat).find('.aa_fileSection__file').each(function () {
            formData.push({
                name:'compName[]',
                value:$(this).data("comp"),
            });
        });

       formData.push({
           name:'currentCat',
           value: currentCat
       });

        console.log(formData);

        $.ajax({
                type: 'POST',
                url: 'atomic-core/temp-processing/temp-nav-comp-sort.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
            .done(function (data) {
                console.log(data);
                if (!data.success) {



                } else {
                    console.log('success');
                    window.location = 'atomic-core/?cat='+currentCat+'';
                }
            })
            .fail(function (data) {
                console.log('failed');
            });
    },





     /*onStart: function (evt) {
         var itemEl = evt.item;  // dragged HTMLElement
         var currentComp = $(itemEl).data("comp");
         var currentCat = $(itemEl).data("cat");
         console.log('Component name: ' + currentComp);
         console.log('Current category: ' + currentCat);
     },*/



     onAdd: function (evt) {
         var itemEl = evt.item;  // dragged HTMLElement
         var newCat = $(itemEl).closest('.aa_dir').data("navitem");
         var oldCat = $(itemEl).data("cat");
         var thisCompName = $(itemEl).data("comp");
          /*console.log('New category: ' + newCat);
         console.log('Old category: ' + oldCat);*/

         var formData = [];

         $(".fileSection-"+newCat).find('.aa_fileSection__file').each(function () {

             formData.push({
                 name:'compName[]',
                 value:$(this).data("comp")
             });
         });

         formData.push({
             name:'thisCompName',
             value: thisCompName
         });

         formData.push({
             name:'newCat',
             value: newCat
         });

         formData.push({
             name:'oldCat',
             value: oldCat
         });

         $.ajax({
                 type: 'POST',
                 url: 'atomic-core/temp-processing/temp-nav-compCat-sort.php',
                 data: formData,
                 dataType: 'json',
                 encode: true
             })
             .done(function (data) {
                 console.log(data);
                 if (!data.success) {
                     if (data.errors.exists) {
                         $('.aa_errorBox__message').html("");
                         $('.atoms-main').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.exists + '</p></div>').find('.aa_errorBox').hide().fadeIn(200).delay(1000)
                             .queue(function () {
                                 window.location = 'atomic-core/?cat='+oldCat+'';
                             });




                     }


                     if (data.errors.name) {
                         $('.aa_errorBox__message').html("");
                         $('.aa_actionDrawer').prepend('<div class="aa_errorBox"><p class="aa_errorBox__message"><i class="fa fa-times aa_js-errorBox__close"></i> ' + data.errors.name + '</p></div>').find('.aa_errorBox').hide().fadeIn(200);
                     }


                 } else {
                     console.log('success');
                     window.location = 'atomic-core/?cat='+newCat+'';
                 }
             })
             .fail(function (data) {
                 console.log('failed');
             });



     }

});






