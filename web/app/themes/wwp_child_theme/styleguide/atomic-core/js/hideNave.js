function showSideBar(){
    $(".atoms-side").velocity({
        translateX: "0",
    }, {
        duration: 200
    });
    $(".atoms-side_show-small").velocity({
        left: "-100%",
    }, {
        duration: 200
    });
    $(".atoms-main").velocity({
        paddingLeft: "282px",
    }, {
        duration: 200
    });
}
function hideSideBar(){
    $(".atoms-side").velocity({
        translateX: "-100%",
    }, {
        duration: 200
    });

    $(".atoms-side_show-small").velocity({
        left: "10px",
    }, {
        duration: 200
    });



    $(".atoms-main").velocity({
        paddingLeft: "40px",
    }, {
        duration: 200
    });

}


$(".atoms-side_show-small").on('click', function(event) {
    event.preventDefault();
    showSideBar();
});

$(".js-hideSide").on('click', function(event) {
    event.preventDefault();
    hideSideBar();
});




