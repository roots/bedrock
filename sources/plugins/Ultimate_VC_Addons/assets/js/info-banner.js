(function($) {
	$(document).ready(function(){
		align_info();
		
		$(window).resize(function(){
			align_info();
		});

		// CSS3 Transitions.
		jQuery('.ultb3-box .ultb3-info').each(function(){
			if(jQuery(this).attr('data-animation')) {
				jQuery(this).css('opacity','0');
				var animationName = jQuery(this).attr('data-animation'),
					animationDelay = "delay-"+jQuery(this).attr('data-animation-delay');
				jQuery(this).bsf_appear(function() {
					var $this = jQuery(this);
					//$this.css('opacity','0');
					//setTimeout(function(){
						$this.addClass('animated').addClass(animationName);
						$this.addClass('animated').addClass(animationDelay);
						$this.css('opacity','1');
					//},1000);
				},{accY: -70});
			} 
		});
	});
	
	$(window).load(function(){
		align_info();
	});
	
	function align_info()
	{
		$('.ultb3-box').each(function(i,ib){
			var ib_height = $(ib).outerHeight();
			var ib_info_height = $(ib).find('.ultb3-info').outerHeight();
			var diff = (ib_height-ib_info_height)/2;
			$(ib).find('.ultb3-info').css({'top':diff});
		});
	}
}( jQuery ));