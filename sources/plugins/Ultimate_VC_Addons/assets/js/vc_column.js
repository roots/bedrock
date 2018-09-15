(function ( jQuery ) {
	jQuery.fn.ultimate_column_shift = function(option) {
		jQuery(this).each(function(){			
			var br_rad = jQuery(this).data('border-radius');
			var txt_color = jQuery(this).data('txt-color');
			var bg_col = jQuery(this).data('bg-color');
			var br_style = jQuery(this).data('br-style');
			var br_width = jQuery(this).data('br-width');
			var br_color = jQuery(this).data('br-color');
			var cl_pad = jQuery(this).data('cl-pad');
			var cl_margin = jQuery(this).data('cl-margin');
			var ani = jQuery(this).data('animation');
			var ani_delay = jQuery(this).data('animation-delay');
			console.log(ani+' '+ani_delay)
			//console.log('rad'+br_rad+'sty'+br_style+' width'+br_width+' col'+bg_col+' clpad'+cl_pad+' cl-ma'+cl_margin+' brcol'+br_color);
			jQuery(this).prev().css({'border-radius':br_rad,'background-color':bg_col,'padding':cl_pad,'margin':cl_margin,'border-style':br_style,'border-width':br_width+'px','border-color':br_color,'color':txt_color});
			jQuery(this).prev().attr('data-animation',ani);
			jQuery(this).prev().attr('data-animation-delay',ani_delay);
			jQuery(this).remove();
		})
		return this;	
	}
}( jQuery ));
jQuery(document).ready(function(){
	jQuery('.ult-column-param').ultimate_column_shift();
})