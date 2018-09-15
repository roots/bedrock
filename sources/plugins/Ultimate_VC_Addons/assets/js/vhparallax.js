/*
 Plugin: jQuery Parallax
 Version 1.1.3
 Author: Ian Lunn
 Twitter: @IanLunn
 Author URL: http://www.ianlunn.co.uk/
 Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/
 Dual licensed under the MIT and GPL licenses:
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 */
(function( $ ){
	var $window = jQuery(window);
	var windowHeight = $window.height();
	$window.resize(function () {
		windowHeight = $window.height();
	});
	jQuery.fn.vparallax = function(xpos, speedFactor, outerHeight) {
		var $this = jQuery(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		//get the starting position of each element to have parallax applied to it
		/*$this.each(function(){
		    //firstTop = $this.offset().top;
		});*/
		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.5;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		//speedFactor = (jQuery(this).data('parallax_sense'))/100;
		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();
			$this.each(function(){
				firstTop = jQuery(this).offset().top;
				var $element = jQuery(this);
				var top = $element.offset().top;
				var height = getHeight($element);
				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}
				var f = Math.round((firstTop - pos) * speedFactor);
				//if(firstTop >= windowHeight){
					 //f = -f-(speedFactor*windowHeight);
				//}else{
					f=-f;
				//}
				if(jQuery(this).parent().hasClass('vcpb-mlvp-jquery'))
					var is_img_parallax_disable_on_mobile = jQuery(this).parent().parent().data('img-parallax-mobile-disable').toString();
				else
					var is_img_parallax_disable_on_mobile = jQuery(this).parent().data('img-parallax-mobile-disable').toString();
				if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
					var is_mobile = 'false';
				else
					var is_mobile = 'true';
				if(is_img_parallax_disable_on_mobile=='true' && is_mobile=='true')
					var disable_row_parallax_effect = 'true';
				else
					var disable_row_parallax_effect = 'false';
				
				if(disable_row_parallax_effect == 'false')
				{
					//f = -f;
					jQuery(this).css('backgroundPosition', xpos + " " + f + "px");
				}
			});
		}
		$window.bind('scroll', update).resize(update);
		update();
	};
	jQuery.fn.hparallax = function(xpos, speedFactor, outerHeight) {
		var $this = jQuery(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.5;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		speedFactor = (jQuery(this).data('parallax_sense'))/100;
		xpos = '0px';
		var prev_pos = $window.scrollTop();
		// function to be called whenever the window is scrolled or resized
		function update(){
			
			var pos = $window.scrollTop();
			$this.each(function(){
				firstTop = jQuery(this).offset().top;
				var $element = jQuery(this);
				var top = $element.offset().top;
				var height = getHeight($element);
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}
				var bg = jQuery(this).css('backgroundPosition');
				var pxpos = bg.indexOf('px');
				var bgxpos= bg.substring(0,pxpos);
				var f =0;
				if(prev_pos-pos <= 0){
					f = parseInt(bgxpos) - parseInt(speedFactor*(Math.abs(prev_pos-pos)));
				}
				else{
					f = parseInt( bgxpos ) + parseInt( speedFactor * ( prev_pos - pos ) );
					
					if(f>0)
						f=0;
				}
				var is_img_parallax_disable_on_mobile = jQuery(this).parent().data('img-parallax-mobile-disable').toString();
				if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
					var is_mobile = 'false';
				else
					var is_mobile = 'true';
				if(is_mobile == 'true' && is_img_parallax_disable_on_mobile == 'true')
					var disable_row_effect = 'true';
				else
					var disable_row_effect = 'false';
				
				if(disable_row_effect == 'false')
				{
					jQuery(this).css('backgroundPosition', f + "px "+ xpos);
				}
				/*if(this).hasClass('upb_bg_size_automatic'){
					jQuery(this).each(function(){
						var vh = jQuery(window).outerHeight();
						var bh = jQuery(this).parent().outerHeight();
						var speed = jQuery(this).data('parallax_sense');
						var bw = jQuery(this).outerWidth()
						var ih = (((vh+bh)/100)*speed)+bw;
						jQuery(this).css('background-size',ih+'px auto');
					})
				}*/
			});
			prev_pos = pos;
		}
		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);
 // Auto Initialization
 //if( ! jQuery.browser.mobile){
	 jQuery(document).ready(function(){
		 
		if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
			var is_mobile = 'false';
		else
			var is_mobile = 'true';
		
				
	 	jQuery('.vcpb-mlvp-jquery').each(function(){
			var selector = jQuery(this);
			//var sense = selector.data('parallax_sense');
			//var incr =(selector.outerWidth()*(sense/100));
			var img_list = selector.data('img-array');
			img_list = img_list.split(',');
			var img_list_len = img_list.length;
			for (var i = 0; i < img_list_len; i++) {
				jQuery(selector).prepend('<div class="vertical_layer_parallax" style="position:absolute;background-image:url('+img_list[i]+');"></div>')
			};
			var hp = jQuery(selector).find('.vertical_layer_parallax');
			hp.css({'max-width':'none','position':'absolute'});
			//hp.css('min-width',(hp.parent().outerWidth())+incr+'px');
		});
		jQuery('.vcpb-mlvp-jquery').each(function(){
			var layer_count = jQuery(this).find('.vertical_layer_parallax').length;
			var sense = parseInt(jQuery(this).data('parallax_sense'))/100;
			var is_img_parallax_disable_on_mobile = jQuery(this).parent().data('img-parallax-mobile-disable').toString();
			layer_count = (sense)/layer_count;
			sense = 0;
			
			if(is_mobile == 'true' && is_img_parallax_disable_on_mobile == 'true')
				var disable_row_effect = 'true';
			else
				var disable_row_effect = 'false';
			
			jQuery(this).find('.vertical_layer_parallax').each(function(index){
				sense += layer_count;
				jQuery(this).css({'height':jQuery(this).parent().outerHeight()+'px','width':jQuery(this).parent().outerWidth()+'px',}).
				attr('data-p-sense',sense);
				if(disable_row_effect == 'false')
					jQuery(this).vparallax("0%",sense);
			})
		})
	 	//jQuery('.vcpb-vz-jquery').vparallax();
	 	jQuery('.vcpb-vz-jquery').each(function(){
			var is_img_parallax_disable_on_mobile = jQuery(this).parent().data('img-parallax-mobile-disable');
			if(is_mobile == 'true' && is_img_parallax_disable_on_mobile == 'true')
				var disable_row_effect = 'true';
			else
				var disable_row_effect = 'false';
			if(disable_row_effect == 'false')
	 			jQuery(this).vparallax("50%",jQuery(this).data('parallax_sense')/100);
	 	})
	 	jQuery('.vcpb-hz-jquery').hparallax();
	 	if(jQuery('.vcpb-hz-jquery').length>0){
	 		setTimeout(function() {
				jQuery(window).scrollTop(0);
			}, 1000);
	 	}
	 })
//}
