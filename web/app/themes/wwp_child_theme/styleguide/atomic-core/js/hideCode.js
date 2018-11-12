/*if ($(".atoms-code-example")[0]) {
    $(".js-hideCode").on('click', function (event) {
        if ($('.compCodeBox').css('opacity') == '0') {
            $(this).css('color', '#fff');
            $(".compCodeBox").velocity({
                opacity: "1",
            }, {
                duration: 200
            });
        } else {
            $(this).css('color', '#247695');
            $(".compCodeBox").velocity({
                opacity: "0",
            }, {
                duration: 200
            });
        }
    });
}*/


$(".js-hideCode").on('click', function (event) {

    if ($('.codeBlocks').css('display') == 'none') {
        $('.codeBlocks').fadeIn();
    } else {
        $('.codeBlocks').fadeOut();
    }
});






