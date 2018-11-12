function actionsWidth() {
    $side = $('.atoms-side');
    $body = $('body');
    $action = $('.aa_js-actionDrawer');
    sideWidth = $($side).outerWidth();
    bodyWidth = $('body').outerWidth();
    $action.css('width', bodyWidth - sideWidth - 1);
}

actionsWidth();
$(window).resize(function () {
    actionsWidth();
});


var actionOpen = [
    {elements: $(".aa_js-actionDrawer"), properties: {right: "auto"}, options: {duration: 300}},

];

var actionClose = [
    {elements: $(".aa_js-actionDrawer"), properties: {right: "-100%"}, options: {duration: 300}},
];


$(".aa_js-actionOpen").on('click', function (event) {
    event.preventDefault();
    $.Velocity.RunSequence(actionOpen);
    $('body').addClass('sidebar-open');
});

$(".aa_js-actionClose").on('click', function (event) {
    event.preventDefault();
    $.Velocity.RunSequence(actionClose);
    $('body').removeClass('sidebar-open');
});


$('body').on('click', '.aa_js-actionOpen', function (events) {
    $('.aa_errorBox').remove();
});

$('body').on('click', '.aa_js-errorBox__close', function (events) {
    $('.aa_errorBox').fadeOut(200);
});


