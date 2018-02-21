jQuery(document).ready(function($) {

  $('#widgets-right').on('click', '.esmp-tab-item', function(event) {
    event.preventDefault();
    var widget = $(this).parents('.widget');
    console.log(widget);
    widget.find('.esmp-tab-item').removeClass('active');
    $(this).addClass('active');
    widget.find('.esmp-tab').addClass('esmp-hide');
    widget.find('.' + $(this).data('toggle')).removeClass('esmp-hide');
  });

});