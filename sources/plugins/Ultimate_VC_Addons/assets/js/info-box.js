jQuery(window).load(function(a){
	info_box_set_auto_height();
});
jQuery(document).ready(function(a) {
	info_box_set_auto_height();
	jQuery(window).resize(function(a){
		info_box_set_auto_height();
	});
});
function info_box_set_auto_height() {
	jQuery('.aio-icon-box.square_box-icon').each(function(index, value) {
		var WW = jQuery(window).width() || '';
		if(WW!='') {
			if(WW>=768) {
				var h = jQuery(this).attr('data-min-height') || '';
				if(h!='') {
					jQuery(this).css('min-height', h);
				}
			} else {
				jQuery(this).css('min-height', 'initial');
			}
		}
	});
}