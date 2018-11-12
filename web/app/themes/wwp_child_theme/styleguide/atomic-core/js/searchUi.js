
$('.js_searchTrigger').click(function() {
    $('.searchWindow').fadeIn(250);
    $('.searchInput').focus();
});


$('.searchList .name').click(function() {
    $('.searchWindow').fadeOut(250);
});


$('.js_searchWindow__close').click(function() {
    $('.searchWindow').fadeOut(250);
});


/*$('.js_searchTrigger').click(function() {
    $('.searchWindow').addClass('searchWindow-open');
    $('.searchInput').focus();
});


$('.js_searchWindow__close').click(function() {
    $('.searchWindow').removeClass('searchWindow-open');
});*/


$(document).mouseup(function (e)
{
    var container = $('.atomic-search');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.removeClass('atomic-search-open');
    }
});




