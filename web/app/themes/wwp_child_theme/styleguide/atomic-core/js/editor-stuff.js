$(document).ready(function() {


    /*var editorHeight = $('.ace_content').outerHeight();

     console.log(editorHeight);

     if(editorHeight < 166){
     $( ".js-expand" ).remove();
     }*/


    $( ".js-expand" ).click(function(e) {
        e.preventDefault();
        //$('.codeBlocks').removeClass('codeBlocks-open');
        $(this).closest('.codeBlocks').toggleClass('codeBlocks-open');
    });

    $( ".ace_content" ).click(function() {
        $('.codeBlocks').removeClass('atomic-editorWrap-active');
        $(this).closest('.codeBlocks').addClass('atomic-editorWrap-active');
    });

    $( ".js-close-editor" ).click(function() {
        $('.codeBlocks').removeClass('atomic-editorWrap-active');
        location.reload();
    });


    $( ".js-copyBtn-edit" ).click(function() {
        $('.codeBlocks').removeClass('atomic-editorWrap-active');
        $(this).closest('.codeBlocks').addClass('atomic-editorWrap-active');
    });

    $( ".js-copyBtn" ).click(function() {
        var copyInputId = '#'+$(this).data("copy-target"),
            target = document.createElement("textarea");
        target.style.position = "absolute";
        target.style.left = "-9999px";
        target.style.top = "0";
        document.body.appendChild(target);
        target.textContent = $(copyInputId).val();

        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }
    });

});

$(document).mouseup(function (e)
{
    var container = $('.codeBlocks');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.removeClass('atomic-editorWrap-active');
    }
});
