jQuery(document).ready(function($) {
    BSFMouseSmoothScroll();
});
function BSFMouseSmoothScroll() {
	var ult_smooth_speed = parseInt(jQuery('html').attr('data-ult_smooth_speed'));
	var ult_smooth_step = parseInt(jQuery('html').attr('data-ult_smooth_step'));
	if(typeof ult_smooth_speed === 'undefined') {
		var ult_smooth_speed = 480;
	}
	if(typeof ult_smooth_step === 'undefined') {
		var ult_smooth_step = 80;
	}
    jQuery.srSmoothscroll({
        step: ult_smooth_step,
        speed: ult_smooth_speed,
        ease: 'easeOutSine',
        target: jQuery('body'),
        container: jQuery(window)
    });
}