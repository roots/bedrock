;(function ( $, window, undefined ) {
    // Hide until page load
    $( window ).load(function() {
        $('.ult-ih-container').css({'visibility':'visible', 'opacity':1});
    });
    $(document).ready(function () {
        ult_ihover_init();
		$(document).ajaxComplete(function(e, xhr, settings){
			ult_ihover_init();
		});
    });
    $(window).resize(function(){
        ult_ihover_init();
    });
    function responsive_sizes(el, ww, h, w, rh, rw) {
        if(ww!='') {
            if(ww>=768) {
                $(el).find('.ult-ih-item, .ult-ih-img, .ult-ih-image-block, .ult-ih-list-item').css({'height': h,'width': w});
            } else {
                $(el).find('.ult-ih-item, .ult-ih-img, .ult-ih-image-block, .ult-ih-list-item').css({'height': rh,'width': rw});
            }
        }
    }
    function ult_ihover_init() {
        $('.ult-ih-list').each(function(index, el){
            var s   = $(el).attr('data-shape');
            var h  = $(el).attr('data-height');
            var w   = $(el).attr('data-width');
            var rh = $(el).attr('data-res_height');
            var rw  = $(el).attr('data-res_width');
            var ww = jQuery(window).width() || '';
                
            $(el).find('li').each(function(){

                // Shape
                $(el).find('.ult-ih-item').addClass('ult-ih-' + s);

                // Responsive & Normal
                responsive_sizes(el, ww, h, w, rh, rw);

            });
        });
	}

}(jQuery, window));