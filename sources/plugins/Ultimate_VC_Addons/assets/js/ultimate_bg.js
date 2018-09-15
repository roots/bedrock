(function ( $ ) {
	jQuery(document).ready(function(){

		function version_compare(strVersionA, strVersionB) {
		    var arrVersionA = strVersionA.split('.');
		    var arrVersionB = strVersionB.split('.');
		    var intVersionA = (100000000 * parseInt(arrVersionA[0])) + (1000000 * parseInt(arrVersionA[1])) + (10000 * parseInt(arrVersionA[2]));
		    var intVersionB = (100000000 * parseInt(arrVersionB[0])) + (1000000 * parseInt(arrVersionB[1])) + (10000 * parseInt(arrVersionB[2]));

		    if (intVersionA > intVersionB) {
		        return 1;
		    }else if(intVersionA < intVersionB){
		        return -1;
		    }else{
		        return 0;
		    }
		    return false;
		}

		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			$('html').addClass('ult-remove-fixed-background');
		}

		jQuery(window).scroll(function(){
			vc_viewport_video();
		});

		jQuery(window).load(function(){
			vc_viewport_video();
		});

		 function vc_viewport_video()
			{
				if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
					return false;
				jQuery('.enable-on-viewport').each(function(index, element) {
					var is_on_viewport = jQuery(this).isVdoOnScreen();
					if(jQuery(this).hasClass('hosted-video') && (!jQuery(this).hasClass('override-controls')))
					{
						if(is_on_viewport)
						{
							jQuery(this)[0].play();
							jQuery(this).parent().parent().parent().find('.video-controls').attr('data-action','play');
							jQuery(this).parent().parent().parent().find('.video-controls').html('<i class="ult-vid-cntrlpause"></i>');
						}
						else
						{
							jQuery(this)[0].pause();
							jQuery(this).parent().parent().parent().find('.video-controls').attr('data-action','pause');
							jQuery(this).parent().parent().parent().find('.video-controls').html('<i class="ult-vid-cntrlplay"></i>');
						}
					}
				});
			}

			function ultHexToRgb(hex) {
	    		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
			    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
			    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			        return r + r + g + g + b + b;
			    });

			    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
			    return result ? {
			        r: parseInt(result[1], 16),
			        g: parseInt(result[2], 16),
			        b: parseInt(result[3], 16)
			    } : null;
			}

			/* function for seperators */
			function ult_vc_seperators(selector, parent)
			{
				/* seperators */
				var seperator = selector.data('seperator');
				var seperator_type = selector.data('seperator-type');
				var seperator_shape_size = selector.data('seperator-shape-size');
				var seperator_background_color = selector.data('seperator-background-color');
				var seperator_border = selector.data('seperator-border');
				var seperator_border_color = selector.data('seperator-border-color');
				var seperator_border_width = selector.data('seperator-border-width');
				var seperator_svg_height = selector.data('seperator-svg-height');
				var seperator_full_width = selector.data('seperator-full-width');
				var seperator_position = selector.data('seperator-position');
				if(typeof seperator_position == 'undefined' || seperator_position == '')
					seperator_position = 'top_seperator';

				var icon = selector.data('icon');

				if(typeof icon == 'undefined')
					icon = '';
				else
					icon = '<div class="separator-icon">'+icon+'</div>';

				var seperator_css_main = seperator_class = seperator_border_css = seperator_border_line_css = seperator_css = '';
				if(typeof seperator != 'undefined' && seperator.toString() == 'true')
				{
					var css = shape_css = svg = inner_html = seperator_css = shape_css = '';
					var is_svg = false;

					var uniqid = Math.floor( Math.random()*9999999999999);
					var uniqclass = 'uvc-seperator-'+uniqid;

					if(typeof seperator_shape_size == 'undefined' || seperator_shape_size == '' || seperator_shape_size == 'undefined')
							seperator_shape_size = 0;

					seperator_shape_size = parseInt(seperator_shape_size);
					var half_shape = seperator_shape_size/2;
					var half_border = 0;

					if(seperator_type == 'triangle_seperator')
						seperator_class = 'ult-trinalge-seperator';
					else if(seperator_type == 'circle_seperator')
						seperator_class = 'ult-circle-seperator';
					else if(seperator_type == 'diagonal_seperator')
						seperator_class = 'ult-double-diagonal';
					else if(seperator_type == 'triangle_svg_seperator')
					{
						seperator_class = 'ult-svg-triangle';
						svg = '<svg class="uvc-svg-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 0.156661 0.1"><polygon points="0.156661,3.93701e-006 0.156661,0.000429134 0.117665,0.05 0.0783307,0.0999961 0.0389961,0.05 -0,0.000429134 -0,3.93701e-006 0.0783307,3.93701e-006 "/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'circle_svg_seperator')
					{
						seperator_class = 'ult-svg-circle';
						svg = '<svg class="uvc-svg-circle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 0.2 0.1"><path d="M0.200004 0c-3.93701e-006,0.0552205 -0.0447795,0.1 -0.100004,0.1 -0.0552126,0 -0.0999921,-0.0447795 -0.1,-0.1l0.200004 0z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'xlarge_triangle_seperator')
					{
						seperator_class = 'ult-xlarge-triangle';
						svg = '<svg class="uvc-x-large-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none"><path class="fil0" d="M-0 0.333331l4.66666 0 0 -3.93701e-006 -2.33333 0 -2.33333 0 0 3.93701e-006zm0 -0.333331l4.66666 0 0 0.166661 -4.66666 0 0 -0.166661zm4.66666 0.332618l0 -0.165953 -4.66666 0 0 0.165953 1.16162 -0.0826181 1.17171 -0.0833228 1.17171 0.0833228 1.16162 0.0826181z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'xlarge_triangle_left_seperator')
					{
						seperator_class = 'ult-xlarge-triangle-left';
						svg = '<svg class="uvc-x-large-triangle-left" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 2000 90" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'xlarge_triangle_right_seperator')
					{
						seperator_class = 'ult-xlarge-triangle-right';
						svg = '<svg class="uvc-x-large-triangle-right" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 2000 90" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'xlarge_circle_seperator')
					{
						seperator_class = 'ult-xlarge-circle';
						svg = '<svg class="uvc-x-large-circle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none"><path class="fil1" d="M4.66666 0l0 7.87402e-006 -3.93701e-006 0c0,0.0920315 -1.04489,0.166665 -2.33333,0.166665 -1.28844,0 -2.33333,-0.0746339 -2.33333,-0.166665l-3.93701e-006 0 0 -7.87402e-006 4.66666 0z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'curve_up_seperator')
					{
						seperator_class = 'ult-curve-up-seperator';
						svg = '<svg class="curve-up-inner-seperator uvc-curve-up-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none"><path class="fil0" d="M-7.87402e-006 0.0148858l0.00234646 0c0.052689,0.0154094 0.554437,0.154539 1.51807,0.166524l0.267925 0c0.0227165,-0.00026378 0.0456102,-0.000582677 0.0687992,-0.001 1.1559,-0.0208465 2.34191,-0.147224 2.79148,-0.165524l0.0180591 0 0 0.166661 -7.87402e-006 0 0 0.151783 -4.66666 0 0 -0.151783 -7.87402e-006 0 0 -0.166661z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'curve_down_seperator')
					{
						seperator_class = 'ult-curve-down-seperator';
						svg = '<svg class="curve-down-inner-seperator uvc-curve-down-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none"><path class="fil0" d="M-7.87402e-006 0.0148858l0.00234646 0c0.052689,0.0154094 0.554437,0.154539 1.51807,0.166524l0.267925 0c0.0227165,-0.00026378 0.0456102,-0.000582677 0.0687992,-0.001 1.1559,-0.0208465 2.34191,-0.147224 2.79148,-0.165524l0.0180591 0 0 0.166661 -7.87402e-006 0 0 0.151783 -4.66666 0 0 -0.151783 -7.87402e-006 0 0 -0.166661z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'tilt_left_seperator')
					{
						seperator_class = 'ult-tilt-left-seperator';
						svg = '<svg class="uvc-tilt-left-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4 0.266661" preserveAspectRatio="none"><polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'tilt_right_seperator')
					{
						seperator_class = 'ult-tilt-right-seperator';
						svg = '<svg class="uvc-tilt-right-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 4 0.266661" preserveAspectRatio="none"><polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'waves_seperator')
					{
						seperator_class = 'ult-wave-seperator';
						svg = '<svg class="wave-inner-seperator uvc-wave-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 6 0.1" preserveAspectRatio="none"><path d="M0.199945 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c-0.0541102,0 -0.0981929,-0.0430079 -0.0999409,-0.0967008l0 0.0967008 0.0999409 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm2.00004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm-0.1 0.1l-0.200008 0c-0.0552126,0 -0.0999921,-0.0447795 -0.1,-0.1 -7.87402e-006,0.0552205 -0.0447874,0.1 -0.1,0.1l0.2 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1 3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1zm-0.400008 0l-0.200008 0c-0.0552126,0 -0.0999921,-0.0447795 -0.1,-0.1 -7.87402e-006,0.0552205 -0.0447874,0.1 -0.1,0.1l0.2 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1 3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1zm-0.400008 0l-0.200008 0c-0.0552126,0 -0.0999921,-0.0447795 -0.1,-0.1 -7.87402e-006,0.0552205 -0.0447874,0.1 -0.1,0.1l0.2 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1 3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1zm-0.400008 0l-0.200008 0c-0.0552126,0 -0.0999921,-0.0447795 -0.1,-0.1 -7.87402e-006,0.0552205 -0.0447874,0.1 -0.1,0.1l0.2 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1 3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1zm-0.400008 0l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1 3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1zm1.90004 -0.1c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.200004 0c7.87402e-006,0.0552205 0.0447874,0.1 0.1,0.1l-0.2 0c0.0552126,0 0.0999921,-0.0447795 0.1,-0.1zm0.200004 0c3.93701e-006,0.0552205 0.0447795,0.1 0.100004,0.1l-0.200008 0c0.0552244,0 0.1,-0.0447795 0.100004,-0.1zm0.199945 0.00329921l0 0.0967008 -0.0999409 0c0.0541102,0 0.0981929,-0.0430079 0.0999409,-0.0967008z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'clouds_seperator')
					{
						seperator_class = 'ult-cloud-seperator';
						svg = '<svg class="cloud-inner-seperator uvc-cloud-seperator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="'+seperator_background_color+'" width="100%" height="'+seperator_svg_height+'" viewBox="0 0 2.23333 0.1" preserveAspectRatio="none"><path class="fil0" d="M2.23281 0.0372047c0,0 -0.0261929,-0.000389764 -0.0423307,-0.00584252 0,0 -0.0356181,0.0278268 -0.0865354,0.0212205 0,0 -0.0347835,-0.00524803 -0.0579094,-0.0283701 0,0 -0.0334252,0.0112677 -0.0773425,-0.00116929 0,0 -0.0590787,0.0524724 -0.141472,0.000779528 0,0 -0.0288189,0.0189291 -0.0762362,0.0111535 -0.00458268,0.0141024 -0.0150945,0.040122 -0.0656811,0.0432598 -0.0505866,0.0031378 -0.076126,-0.0226614 -0.0808425,-0.0308228 -0.00806299,0.000854331 -0.0819961,0.0186969 -0.111488,-0.022815 -0.0076378,0.0114843 -0.059185,0.0252598 -0.083563,-0.000385827 -0.0295945,0.0508661 -0.111996,0.0664843 -0.153752,0.019 -0.0179843,0.00227559 -0.0571181,0.00573622 -0.0732795,-0.0152953 -0.027748,0.0419646 -0.110602,0.0366654 -0.138701,0.00688189 0,0 -0.0771732,0.0395709 -0.116598,-0.0147677 0,0 -0.0497598,0.02 -0.0773346,-0.00166929 0,0 -0.0479646,0.0302756 -0.0998937,0.00944094 0,0 -0.0252638,0.0107874 -0.0839488,0.00884646 0,0 -0.046252,0.000775591 -0.0734567,-0.0237087 0,0 -0.046252,0.0101024 -0.0769567,-0.00116929 0,0 -0.0450827,0.0314843 -0.118543,0.0108858 0,0 -0.0715118,0.0609803 -0.144579,0.00423228 0,0 -0.0385787,0.00770079 -0.0646299,0.000102362 0,0 -0.0387559,0.0432205 -0.125039,0.0206811 0,0 -0.0324409,0.0181024 -0.0621457,0.0111063l-3.93701e-005 0.0412205 2.2323 0 0 -0.0627953z"/></svg>';
						is_svg = true;
					}
					else if(seperator_type == 'multi_triangle_seperator') {
						seperator_class = 'ult-multi-trianle';
						var rgb = ultHexToRgb(seperator_background_color);
						svg = '<svg class="uvc-multi-triangle-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" width="100%" height="'+seperator_svg_height+'">\
				            <path class="large left" d="M0 0 L50 50 L0 100" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .1)"></path>\
				            <path class="large right" d="M100 0 L50 50 L100 100" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .1)"></path>\
				            <path class="medium left" d="M0 100 L50 50 L0 33.3" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .3)"></path>\
				            <path class="medium right" d="M100 100 L50 50 L100 33.3" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .3)"></path>\
				            <path class="small left" d="M0 100 L50 50 L0 66.6" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .5)"></path>\
				            <path class="small right" d="M100 100 L50 50 L100 66.6" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', .5)"></path>\
				            <path d="M0 99.9 L50 49.9 L100 99.9 L0 99.9" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', 1)"></path>\
				            <path d="M48 52 L50 49 L52 52 L48 52" fill="rgba('+rgb.r+','+rgb.g+','+rgb.b+', 1)"></path>\
				        </svg>';
				        is_svg = true;
					}
					else if(seperator_type == 'round_split_seperator')
					{
						var temp_css = temp_border_before = temp_border_after = temp_border_line = '';
						temp_padding = 0;
						seperator_class = 'ult-rounded-split-seperator-wrapper';
						var row_height = jQuery(selector).outerHeight();

						if(seperator_shape_size != 0)
						{
							var prev_padding = parseInt(jQuery(selector).css('padding-bottom'));
							jQuery(selector).css({'padding-bottom':seperator_shape_size+'px'});
							if(prev_padding == 0)
								temp_padding = seperator_shape_size;
						}
						if(seperator_position == 'top_seperator')
						{
							var eclass = 'top-split-seperator';
							var etop = '0px';
							var ebottom = 'auto';
							var border_radius_before = 'border-radius: 0 0 '+seperator_shape_size+'px 0 !important;';
							var border_radius_after = 'border-radius: 0 0 0 '+seperator_shape_size+'px !important;';
						}
						else if(seperator_position == 'bottom_seperator')
						{
							var eclass = 'bottom-split-seperator';
							var etop = 'auto';
							var ebottom = '0px';
							var border_radius_before = 'border-radius: 0 '+seperator_shape_size+'px 0 0 !important;';
							var border_radius_after = 'border-radius: '+seperator_shape_size+'px 0 0 0 !important;';
						}
						else
						{
							var eclass = 'top-bottom-split-seperator';
							var etop_top = '0px';
							var ebottom_top = 'auto';
							var etop_bottom = 'auto';
							var ebottom_bottom = '0px';
							var border_radius_before_top = 'border-radius: 0 0 '+seperator_shape_size+'px 0 !important;';
							var border_radius_after_top = 'border-radius: 0 0 0 '+seperator_shape_size+'px !important;';
							var border_radius_before_bottom = 'border-radius: 0 '+seperator_shape_size+'px 0 0 !important;';
							var border_radius_after_bottom = 'border-radius: '+seperator_shape_size+'px 0 0 0 !important;';
						}
						inner_html = '<div class="ult-rounded-split-seperator '+eclass+'"></div>';

						if(seperator_border != 'none')
						{
							temp_border_line = seperator_border_width+'px '+seperator_border+' '+seperator_border_color;
							temp_border_before = 'border-top: '+temp_border_line+'; border-right: '+temp_border_line+';';
							temp_border_after = 'border-top: '+temp_border_line+'; border-left: '+temp_border_line+';';
						}

						if(seperator_position == 'top_seperator' || seperator_position == 'bottom_seperator')
						{
							temp_css = '<style>.'+uniqclass+' .ult-rounded-split-seperator.'+eclass+':before { background-color:'+seperator_background_color+'; height:'+seperator_shape_size+'px !important; top:'+etop+'; bottom:'+ebottom+'; '+temp_border_before+' '+border_radius_before+' } .'+uniqclass+' .ult-rounded-split-seperator.'+eclass+':after { background-color:'+seperator_background_color+'; left: 50%; height:'+seperator_shape_size+'px !important; top:'+etop+'; bottom:'+ebottom+'; '+temp_border_after+' '+border_radius_after+' }</style>';
							jQuery('head').append(temp_css);
						}
						else
						{
							temp_css = '<style>.'+uniqclass+'.top_seperator .ult-rounded-split-seperator:before { background-color:'+seperator_background_color+'; height:'+seperator_shape_size+'px !important; top:'+etop_top+'; bottom:'+ebottom_top+'; '+temp_border_before+' '+border_radius_before_top+' } .'+uniqclass+'.top_seperator .ult-rounded-split-seperator:after { background-color:'+seperator_background_color+'; left: 50%; height:'+seperator_shape_size+'px !important; top:'+etop_top+'; bottom:'+ebottom_top+'; '+temp_border_after+' '+border_radius_after_top+' }</style>';
							temp_css_bottom = '<style>.'+uniqclass+'.bottom_seperator .ult-rounded-split-seperator:before { background-color:'+seperator_background_color+'; height:'+seperator_shape_size+'px !important; top:'+etop_bottom+'; bottom:'+ebottom_bottom+'; '+temp_border_before+' '+border_radius_before_bottom+' } .'+uniqclass+'.bottom_seperator .ult-rounded-split-seperator:after { background-color:'+seperator_background_color+'; left: 50%; height:'+seperator_shape_size+'px !important; top:'+etop_bottom+'; bottom:'+ebottom_bottom+'; '+temp_border_after+' '+border_radius_after_bottom+' }</style>';
							jQuery('head').append(temp_css+temp_css_bottom);
						}
					}
					else
						seperator_class = 'ult-no-shape-seperator';

					if(typeof seperator_border_width != 'undefined' && seperator_border_width != '' && seperator_border_width != 0)
					{
						half_border = parseInt(seperator_border_width);
					}
					shape_css = 'content: "";width:'+seperator_shape_size+'px; height:'+seperator_shape_size+'px; bottom: -'+(half_shape+half_border)+'px;';

					if(seperator_background_color != '')
						shape_css += 'background-color:'+seperator_background_color+';';

					if(seperator_border != 'none' && seperator_class != 'ult-rounded-split-seperator-wrapper' && is_svg == false)
					{
						seperator_border_line_css = seperator_border_width+'px '+seperator_border+' '+seperator_border_color;
						shape_css += 'border-bottom:'+seperator_border_line_css+'; border-right:'+seperator_border_line_css+';';
						seperator_css += 'border-bottom:'+seperator_border_line_css+';';
						seperator_css_main = 'bottom:'+seperator_border_width+'px !important';
					}

					if(seperator_class != 'ult-no-shape-seperator' && seperator_class != 'ult-rounded-split-seperator-wrapper' && is_svg == false)
					{
						var css = '<style>.'+uniqclass+' .ult-main-seperator-inner:after { '+shape_css+' }</style>';
						jQuery('head').append(css);
					}

					if(is_svg == true)
					{
						inner_html = svg;
					}

					if(seperator_position == 'top_bottom_seperator')
					{
						var seperator_html = '<div class="ult-vc-seperator top_seperator '+seperator_class+' '+uniqclass+'" data-full-width="'+seperator_full_width+'" data-border="'+seperator_border+'" data-border-width="'+seperator_border_width+'"><div class="ult-main-seperator-inner">'+inner_html+'</div>'+icon+'</div>';
						seperator_html += '<div class="ult-vc-seperator bottom_seperator '+seperator_class+' '+uniqclass+'" data-full-width="'+seperator_full_width+'" data-border="'+seperator_border+'" data-border-width="'+seperator_border_width+'"><div class="ult-main-seperator-inner">'+inner_html+'</div>'+icon+'</div>';
					}
					else
					{
						var seperator_html = '<div class="ult-vc-seperator '+seperator_position+' '+seperator_class+' '+uniqclass+'" data-full-width="'+seperator_full_width+'" data-border="'+seperator_border+'" data-border-width="'+seperator_border_width+'"><div class="ult-main-seperator-inner">'+inner_html+'</div>'+icon+'</div>';
					}
					parent.prepend(seperator_html);

					seperator_css = '<style>.'+uniqclass+' .ult-main-seperator-inner { '+seperator_css+' }</style>';
					if(seperator_css_main != '')
					{
						seperator_css_main = '<style>.'+uniqclass+' .ult-main-seperator-inner { '+seperator_css_main+' }</style>';
						seperator_css += seperator_css_main;
					}
					if(icon != '')
					{
						var t = seperator_svg_height/2;
						if(seperator_type == 'none_seperator' || seperator_type == 'circle_svg_seperator' || seperator_type == 'triangle_svg_seperator')
							seperator_css += '<style>.'+uniqclass+' .separator-icon { -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); transform: translate(-50%, -50%); }</style>';
						else
						{
							seperator_css += '<style>.'+uniqclass+'.top_seperator .separator-icon { -webkit-transform: translate(-50%, calc(-50% + '+(t)+'px)); -moz-transform: translate(-50%, calc(-50% + '+(t)+'px)); -ms-transform: translate(-50%, calc(-50% + '+(t)+'px)); -o-transform: translate(-50%, calc(-50% + '+(t)+'px)); transform: translate(-50%, calc(-50% + '+(t)+'px)); } .'+uniqclass+'.bottom_seperator .separator-icon { -webkit-transform: translate(-50%, calc(-50% - '+(t)+'px)); -moz-transform: translate(-50%, calc(-50% - '+(t)+'px)); -ms-transform: translate(-50%, calc(-50% - '+(t)+'px)); -o-transform: translate(-50%, calc(-50% - '+(t)+'px)); transform: translate(-50%, calc(-50% - '+(t)+'px)); }</style>';
						}
					}
					if(is_svg == true)
					{
						jQuery('.'+uniqclass).find('svg').css('height',seperator_svg_height);
						setTimeout(function(){
							if(seperator_type == 'multi_triangle_seperator') {
								jQuery('.ult-multi-trianle').each(function(i,mt){
									var svg_height = $(mt).find('svg').height();
									if($(mt).hasClass('top_seperator')) {
										//$(mt).css('top',-(svg_height-1));
									}
									else if($(mt).hasClass('bottom_seperator')) {
										$(mt).css('bottom',(svg_height-1));
									}
								});
							}
						},300);
					}
					jQuery('head').append(seperator_css);
				}
				/* end of seperators */
			}

		 jQuery.fn.isVdoOnScreen = function(){
			var win =jQuery(window);

			var viewport = {
				top : win.scrollTop(),
				left : win.scrollLeft()
			};
			viewport.right = viewport.left + win.width();
			viewport.bottom = viewport.top + win.height()-200;

			var bounds = this.parent().offset();
			bounds.right = bounds.left + this.parent().outerWidth();
			bounds.bottom = bounds.top + this.parent().outerHeight()-300;

			return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
		};

		jQuery.fn.ultimate_video_bg = function(option) {
			jQuery(this).each(function(){
				var selector =jQuery(this);
				var vdo = selector.data('ultimate-video');
				var vdo2 = selector.data('ultimate-video2');
				var muted =selector.data('ultimate-video-muted');
				var loop =selector.data('ultimate-video-loop');
				var autoplay =selector.data('ultimate-video-autoplay');
				var poster =selector.data('ultimate-video-poster');
				var ride = selector.data('bg-override');
				var start = selector.data('start-time');
				var stop = selector.data('stop-time');
				var anim_style= selector.data('upb-bg-animation');
				var overlay = selector.data('overlay');
				var overlay_color = selector.data('overlay-color');
				var overlay_pattern = selector.data('overlay-pattern');
				var overlay_pattern_opacity = selector.data('overlay-pattern-opacity');
				var overlay_pattern_size = selector.data('overlay-pattern-size');
				var overlay_pattern_attachment = selector.data('overlay-pattern-attachment');
				var viewport_vdo = selector.data('viewport-video');
				var controls = selector.data('controls');
				var controls_color = selector.data('controls-color');
				var fadeout = selector.data('fadeout');
				var fadeout_percentage = selector.data('fadeout-percentage');
				var parallax_content = selector.data('parallax-content');
				var parallax_content_sense = selector.data('parallax-content-sense');
				var disble_mobile = selector.data('row-effect-mobile-disable');
				var hide_row = selector.data('hide-row');
				var rtl = selector.data('rtl');
				var video_fixer = selector.data('video_fixer');
				var multi_color_overlay = '';
				var multi_color_overlay_opacity = '';
				var vc_row_class = selector.data('custom-vc-row');
				var vc = selector.data('vc');
				var theme_support = selector.data('theme-support');
				var is_vc_4_4 = selector.data('is_old_vc');

				if(typeof vc_row_class === 'undefined' || vc_row_class === '')
					vc_row_class = 'wpb_row';

				if(typeof vc === 'undefined')
					vc = 0;

				if(typeof is_vc_4_4 === 'undefined')
					is_vc_4_4 = false;

				if(typeof theme_support === 'undefined')
					theme_support = 'disable';

				if(selector.data('multi-color-overlay'))
				{
					multi_color_overlay = selector.data('multi-color-overlay');
					multi_color_overlay_opacity = selector.data('multi-color-overlay-opacity');
				}

				var overlay_html = overlay_color_html = overlay_pattern_html = overlay_multi_color_html = overlay_pattern_attachment_css = '';

				if(typeof overlay != 'undefined' && overlay.toString() === 'true'){
					if(overlay_pattern != '')
					{
						if(overlay_pattern_size != '')
							overlay_pattern_size = 'background-size:'+overlay_pattern_size+'px;';
						if(typeof overlay_pattern_attachment != 'undefined' && overlay_pattern_attachment != '')
							overlay_pattern_attachment_css = 'background-attachment:'+overlay_pattern_attachment+';';
						overlay_pattern_html = '<div class="upb_bg_overlay_pattern" style="background-image:url('+overlay_pattern+'); opacity:'+overlay_pattern_opacity+'; '+overlay_pattern_size+'; '+overlay_pattern_attachment_css+'"></div>';
					}
					if(overlay_color != '')
						overlay_color_html = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+';"></div>';

					if(multi_color_overlay != '')
						overlay_multi_color_html = '<div class="upb_bg_overlay '+multi_color_overlay+'" style="opacity:'+multi_color_overlay_opacity+';"></div>';

					overlay_html = overlay_color_html+overlay_pattern_html+overlay_multi_color_html;
				}

				if(stop!=0){
					stop = stop;
				}else{
					stop ='';
				}

				//vc = parseFloat(vc);
				if(is_vc_4_4 == true || theme_support == 'enable')
				{
					if(selector.prev().is('p') || selector.prev().is('style'))
						var parent = selector.prev().prev();
					else
						var parent = selector.prev();
				}
				else
				{
					var parent = selector.prevAll('.'+vc_row_class+':first');
				}
				parent.css('position','relative');

				var current_row_classes = parent.attr('class'); // for browser full dimension and 4.9 compatible

				var temp_selector = selector;

				selector = parent;

				var resizee = function(){
					var w,h,ancenstor,al='',bl='';
					ancenstor = selector;
					resize_selector = ancenstor.find('.upb_video-bg');
					if(ride=='full'){
						ancenstor= jQuery('body');
					}
					if(ride=='ex-full'){
						ancenstor= jQuery('html');
					}
					if( ! isNaN(ride)){
						for(var i=0;i<ride;i++){
							if(ancenstor.prop("tagName")!='HTML'){
								ancenstor = ancenstor.parent();
							}else{
								break;
							}
						}
					}
					h = resize_selector.parents('upb_video_class').outerHeight();
					w = ancenstor.outerWidth();
					if(ride=='browser_size'){
						h = jQuery(window).height();
						w = jQuery(window).width();
						ancenstor.css('min-height',h+'px');
					}
					resize_selector.css({'min-height':h+'px','min-width':w+'px'});
					if(ancenstor.offset()){
						al = ancenstor.offset().left;
						if(resize_selector.offset()){
							bl = resize_selector.offset().left;
						}
					}

					var width =w,
					pWidth, // player width, to be defined
					//height = resize_selector.height(),
					height = h,
					pHeight, // player height, tbd
					vimeovideoplayer = resize_selector.find('.upb_vimeo_iframe');
					youvideoplayer = resize_selector.find('.upb_utube_iframe');
					embeddedvideoplayer = resize_selector.find('.upb_video-src');
					var ratio =(16/9);
					if(vimeovideoplayer){
						if (width / ratio < height) { // if new video height < window height (gap underneath)
							pWidth = Math.ceil(height * ratio); // get new player width
							vimeovideoplayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
						} else { // new video width < window width (gap to right)
							pHeight = Math.ceil(width / ratio); // get new player height
							vimeovideoplayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
						}
					}
					if(embeddedvideoplayer){
						var adapt_height = resize_selector.height();
						if (width / (16/9) < adapt_height) {
						//if(w < adapt_height) {
							embeddedvideoplayer.css('width','auto');
							embeddedvideoplayer.css('height','100%');
							//pWidth = Math.ceil(height * (16/9));
							//embeddedvideoplayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0});

						} else {
							embeddedvideoplayer.css('width','100%');
							embeddedvideoplayer.css('height','auto');
							//pHeight = Math.ceil(width / (16/9));
							//youvideoplayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2});
							//embeddedvideoplayer.width(width).height(pHeight).css({left: 0, top: 0});
						}
					}
				}
				resizee();

				// hide row
				if(hide_row != '')
				{
					selector.addClass('ult-vc-hide-row');
					selector.attr('data-hide-row', hide_row);
				}

				// rtl
				selector.attr('data-rtl', rtl);

				selector.addClass('upb_video_class');
				selector.attr('data-row-effect-mobile-disable',disble_mobile);
				if(fadeout == 'fadeout_row_value')
				{
					selector.addClass('vc-row-fade');
					selector.attr('data-fadeout-percentage',fadeout_percentage);
				}

				selector.attr('data-upb_br_animation',anim_style);
				if(vdo){
					if(vdo.indexOf('youtube.com')!=-1){
						option='youtube';
					}
					else if (vdo.indexOf('vimeo.com')!=-1){
						option='vimeo'
					}
				}

				var control_html = '';
				if(controls == 'display_control'){
					if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
					{
						var control_class = 'ult-vid-cntrlplay';
						var control_action = 'pause';
					}
					else
					{
						var control_class = 'ult-vid-cntrlpause';
						var control_action = 'play';
					}

					control_html = '<span class="video-controls" data-action="'+control_action+'" style="color:'+controls_color+'"><i class="'+control_class+'"></i></span>';
				}

				if(ride == "browser_size")
				{
					selector.wrapInner('<div class="upb_video-text-wrapper"><div class="upb_video-text"></div></div>');
					selector.find('.upb_video-text-wrapper').find('.upb_video-text').addClass(current_row_classes);
					//selector.find('.upb_video-text').html(vd_html);
				}

				if(parallax_content == 'parallax_content_value')
				{
					selector.addClass('vc-row-translate');
					selector.attr('data-parallax-content-sense', parallax_content_sense);
					selector.wrapInner('<div class="vc-row-translate-wrapper '+current_row_classes+'"></div>');
					var ptop = selector.css('padding-top');
					var pbottom = selector.css('padding-bottom');
					selector.find('.vc-row-translate-wrapper').css({'padding-top':ptop, 'padding-bottom':pbottom});
					selector[0].style.setProperty( 'padding-top', '0px', 'important' );
					selector[0].style.setProperty( 'padding-bottom', '0px', 'important' );
				}

				var fixer_class = '';
				if(video_fixer.toString() == 'true')
					fixer_class = 'uvc-video-fixer';

				if(option=='youtube' || option=='vimeo')
				{
					selector.prepend('<div class="upb_video-wrapper '+fixer_class+'"><div class="upb_video-bg utube" data-rtl="'+rtl+'" data-bg-override="'+ride+'" data-row="'+vc_row_class+'" data-theme-support="'+theme_support+'">'+overlay_html+'</div></div>');
				}
				else
				{
					selector.prepend(' <div class="upb_video-wrapper"><div class="upb_video-bg" data-bg-override="'+ride+'" data-rtl="'+rtl+'" data-row="'+vc_row_class+'" data-theme-support="'+theme_support+'"><video class="upb_video-src"></video>'+control_html+overlay_html+'</div></div>');
				}

				/* seprators here */
				ult_vc_seperators(temp_selector, selector);
				temp_selector.remove();

				if(option=='youtube'){
					vdo = vdo.substring((vdo.indexOf('watch?v='))+8,(vdo.indexOf('watch?v='))+19);
					var content = selector.find('.upb_video-bg');
					if(loop=='loop') loop=true;
					if(muted=='muted') muted=true;
					content.attr('data-vdo',vdo);content.attr('data-loop',loop);content.attr('data-poster',poster);
					content.attr('data-muted',muted);content.attr('data-start',start);content.attr('data-stop',stop);
					if(viewport_vdo === true)
					{
						content.addClass('enable-on-viewport');
						content.addClass('youtube-video');
						vc_viewport_video();
					}
				}else if(option=='vimeo'){
					vdo = vdo.substring((vdo.indexOf('vimeo.com/'))+10,(vdo.indexOf('vimeo.com/'))+18);
					var content = selector.find('.upb_video-bg');
					content.html('<iframe class="upb_vimeo_iframe" src="http://player.vimeo.com/video/'+vdo+'?portrait=0&amp;byline=0&amp;title=0&amp;badge=0&amp;loop=0&amp;autoplay=1&amp;api=1&amp;rel=0&amp;" height="1600" width="900" frameborder=""></iframe>')
				}
				else{
					var content = selector.find('.upb_video-src');
					hosted_wrapper = content.parent();
					if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || controls == 'display_control')
					{
						jQuery('<source/>', {
							type: 'video/mp4',
							src: vdo
						}).appendTo(content);
						if(typeof vdo2 !== 'undefined' && vdo2 !== '')
						{
							var vdo2_type = '';
							if(vdo2.match(/.ogg/i))
								vdo2_type = 'video/ogg';
							else if(vdo2.match(/.webm/i))
								vdo2_type = 'video/webm';
							if(vdo2_type != '')
							{
								jQuery('<source/>', {
									type: vdo2_type,
									src: vdo2
								}).appendTo(content);
							}
						}

						if(muted=='muted') {
							content.attr({'data-mute':'muted'});
						}

						if(loop=='loop'){ content.attr({'loop':loop}); }
						//if(poster){ content.attr({'poster':poster}); }
						content.attr({'preload':'auto'});
						if(viewport_vdo === true)
						{
							content.addClass('enable-on-viewport');
							content.addClass('hosted-video');
							vc_viewport_video();
						}
						else
						{
							if(autoplay=='autoplay'){ content.attr({'autoplay':autoplay}); }
						}
					}
					else
					{
						if(controls != 'display_control')
						{
							if(poster != '')
							{
								//content.parent().css({'background-image':'url('+poster+')'});
								content.parent().find('.video-controls').hide();
							}

							content.remove();
						}
					}
				}
				if(poster != '')
				{
					console.log(content);
					if(content.is('.utube')) {
						content.css({'background-image':'url('+poster+')'});
					} else {
						hosted_wrapper.css({'background-image':'url('+poster+')'});
					}
				}
				//window.onload = function () {
					jQuery('.upb_video-src').each(function(i,vd){
						var is_muted = jQuery(vd).attr('data-mute');
						if(typeof is_muted === 'undefined')
							is_muted = false;
						if(is_muted === 'muted') {
							var element = jQuery(vd)[0];
							element.muted = "muted";
						}
					});
				//}
			});
			return this;
		}

		jQuery.fn.ultimate_bg_shift = function() {
			jQuery(this).each(function(){
				var selector =jQuery(this);
				var bg = selector.data('ultimate-bg');   // dep in vc v4.1
				var style = selector.data('ultimate-bg-style');
				var bg_color = selector.prev().css('background-color');
				var rep = selector.data('bg-img-repeat');
				var size = selector.data('bg-img-size');
				var pos = selector.data('bg-img-position');
				var sense = selector.data('parallx_sense');
				var ride = selector.data('bg-override');
				var attach = selector.data('bg_img_attach');
				var anim_style= selector.data('upb-bg-animation');
				var al,bl,overlay_color='';
				var overlay= selector.data('overlay');
				var overlay_color = selector.data('overlay-color');
				var overlay_pattern = selector.data('overlay-pattern');
				var overlay_pattern_opacity = selector.data('overlay-pattern-opacity');
				var overlay_pattern_size = selector.data('overlay-pattern-size');
				var overlay_pattern_attachment = selector.data('overlay-pattern-attachment');
				var fadeout = selector.data('fadeout');
				var fadeout_percentage = selector.data('fadeout-percentage');
				var parallax_content = selector.data('parallax-content');
				var parallax_content_sense = selector.data('parallax-content-sense');
				var animation = selector.data('bg-animation');
				var animation_type = selector.data('bg-animation-type');
				var animation_repeat = selector.data('animation-repeat');
				var disble_mobile = selector.data('row-effect-mobile-disable');
				var disble_mobile_img_parallax = selector.data('img-parallax-mobile-disable');
				var hide_row = selector.data('hide-row');
				var rtl = selector.data('rtl');
				var multi_color_overlay = '';
				var multi_color_overlay_opacity = '';
				var vc_row_class = selector.data('custom-vc-row');
				var vc = selector.data('vc');
				var theme_support = selector.data('theme-support');
				var is_vc_4_4 = selector.data('is_old_vc');

				if(typeof vc_row_class === 'undefined' || vc_row_class === '')
					vc_row_class = 'wpb_row';

				if(typeof vc === 'undefined')
					vc = 0;

				if(typeof is_vc_4_4 === 'undefined')
					is_vc_4_4 = false;

				if(typeof theme_support === 'undefined')
					theme_support = 'disable';

				if(selector.data('multi-color-overlay'))
				{
					multi_color_overlay = selector.data('multi-color-overlay');
					multi_color_overlay_opacity = selector.data('multi-color-overlay-opacity');
				}

				var overlay_html = overlay_color_html = overlay_pattern_html = overlay_multi_color_html = overlay_pattern_attachment_css = '';

				if(typeof overlay != 'undefined' && overlay.toString() === 'true'){
					if(overlay_pattern != '')
					{
						if(overlay_pattern_size != '')
							overlay_pattern_size = 'background-size:'+overlay_pattern_size+'px;';
						if(typeof overlay_pattern_attachment != 'undefined' && overlay_pattern_attachment != '')
							overlay_pattern_attachment_css = 'background-attachment:'+overlay_pattern_attachment+';';
						overlay_pattern_html = '<div class="upb_bg_overlay_pattern" style="background-image:url('+overlay_pattern+'); opacity:'+overlay_pattern_opacity+'; '+overlay_pattern_size+'; '+overlay_pattern_attachment_css+'"></div>';
					}
					if(overlay_color != '')
						overlay_color_html = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+';"></div>';
					if(multi_color_overlay != '')
						overlay_multi_color_html = '<div class="upb_bg_overlay '+multi_color_overlay+'" style="opacity:'+multi_color_overlay_opacity+';"></div>';
					overlay_html = overlay_color_html+overlay_pattern_html+overlay_multi_color_html;
				}

				//vc = parseFloat(vc);
				if(is_vc_4_4 == true || theme_support == 'enable')
				{
					if(selector.prev().is('p') || selector.prev().is('style'))
						var parent = selector.prev().prev();
					else
						var parent = selector.prev();
				}
				else
				{
					var parent = selector.prevAll('.'+vc_row_class+':first');
				}
				parent.css('position','relative');

				var current_row_classes = parent.attr('class'); // for browser full dimension and 4.9 compatible

				if(ride == "browser_size")
				{
					parent.wrapInner('<div class="upb-background-text-wrapper"><div class="upb-background-text"></div></div>');
					selector.parent().find('.upb-background-text-wrapper').addClass('full-browser-size');
					selector.parent().find('.upb-background-text-wrapper').find('.upb-background-text').addClass(current_row_classes);
				}

				if(parallax_content == 'parallax_content_value')
				{
					parent.addClass('vc-row-translate');
					parent.attr('data-parallax-content-sense', parallax_content_sense);
					parent.wrapInner('<div class="vc-row-translate-wrapper '+current_row_classes+'"></div>');
					var ptop = parent.css('padding-top');
					var pbottom = parent.css('padding-bottom');
					parent.find('.vc-row-translate-wrapper').css({'padding-top':ptop, 'padding-bottom':pbottom});
					parent[0].style.setProperty( 'padding-top', '0px', 'important' );
					parent[0].style.setProperty( 'padding-bottom', '0px', 'important' );
				}

				// hide row
				if(hide_row != '')
				{
					parent.addClass('ult-vc-hide-row');
					parent.attr('data-hide-row', hide_row);
				}

				// rtl
				parent.attr('data-rtl', rtl);

				parent.prepend('<div class="upb_row_bg">'+overlay_html+'</div>');

				selector.remove();

				/* seprators here */
				ult_vc_seperators(selector, parent);

				selector = parent;

				selector.attr('data-row-effect-mobile-disable',disble_mobile);
				selector.attr('data-img-parallax-mobile-disable',disble_mobile_img_parallax);
				if(fadeout == 'fadeout_row_value')
				{
					selector.addClass('vc-row-fade');
					selector.attr('data-fadeout-percentage',fadeout_percentage);
				}

				selector.css('background-image','');
				selector = selector.find('.upb_row_bg');

				selector.attr('data-upb_br_animation',anim_style);
				if(size!='automatic'){
					selector.css({'background-size':size});
				}
				else{
					selector.addClass('upb_bg_size_automatic');
				}
				selector.css({'background-repeat':rep,'background-position':pos,'background-color':bg_color});
				if(style=='vcpb-fs-jquery' || style=='vcpb-mlvp-jquery'){
					selector.attr('data-img-array',bg);
				}
				else{
					selector.css({'background-image':bg,'background-attachment':attach});
				}
				selector.attr('data-parallax_sense',sense);
				selector.attr('data-bg-override',ride);
				selector.attr('data-bg-animation',animation);
				selector.attr('data-bg-animation-type',animation_type);
				selector.attr('data-animation-repeat',animation_repeat);

				selector.addClass(style);
				var resize = function(){
					var w,h,ancenstor,al,bl;
					ancenstor = selector.parent();
					if(ride=='full'){
						ancenstor= jQuery('body');
						al=0;
					}
					if(ride=='ex-full'){
						ancenstor= jQuery('html');
						al=0;
					}
					if( ! isNaN(ride)){
						for(var i=0;i<ride;i++){
							if(ancenstor.prop("tagName")!='HTML'){
								ancenstor = ancenstor.parent();
							}else{
								break;
							}
						}
						al = ancenstor.offset().left;
					}
					wh = jQuery(window).height();
					h = selector.parent().outerHeight();
					w = ancenstor.outerWidth();
					selector.css({'min-width':w+'px'});
					bl = selector.offset().left;
					selector.css({'left':-(Math.abs(al-bl))+'px'});
					if(ride=='browser_size'){
						var fbh = selector.parent().find('.upb-background-text').height();
						if(fbh > wh)
							wh = fbh;
						selector.parent().css('height',wh+'px');
						//selector.css('min-height',wh+'px');
						selector.parent().find('.upb-background-text-wrapper').css('height',wh+'px');
					}
				}
				resize();
				jQuery(window).load(function(){
					resize();
				});
				jQuery(window).resize(function(){
					resize();
				});
			})
			return this;
		}
		jQuery.fn.ultimate_grad_shift = function() {
			jQuery(this).each(function(){
				var selector =jQuery(this);
				var grad = selector.data('grad');
				var grad_type = selector.data('grad-type');
				var grad_custom_degree = selector.data('grad-custom-degree');

				var ride = jQuery(this).data('bg-override');
				var overlay = selector.data('overlay');
				var overlay_color = selector.data('overlay-color');
				var overlay_pattern = selector.data('overlay-pattern');
				var overlay_pattern_opacity = selector.data('overlay-pattern-opacity');
				var overlay_pattern_size = selector.data('overlay-pattern-size');
				var overlay_pattern_attachment = selector.data('overlay-pattern-attachment');
				var anim_style= selector.data('upb-bg-animation');
				var fadeout = selector.data('fadeout');
				var fadeout_percentage = selector.data('fadeout-percentage');
				var parallax_content = selector.data('parallax-content');
				var parallax_content_sense = selector.data('parallax-content-sense');
				var disble_mobile = selector.data('row-effect-mobile-disable');
				var hide_row = selector.data('hide-row');
				var rtl = selector.data('rtl');
				var multi_color_overlay = '';
				var multi_color_overlay_opacity = '';
				var vc_row_class = selector.data('custom-vc-row');
				var vc = selector.data('vc');
				var theme_support = selector.data('theme-support');
				var is_vc_4_4 = selector.data('is_old_vc');

				if(typeof vc_row_class === 'undefined' || vc_row_class === '')
					vc_row_class = 'wpb_row';

				if(typeof vc === 'undefined')
					vc = 0;

				if(typeof is_vc_4_4 === 'undefined')
					is_vc_4_4 = false;

				if(typeof theme_support === 'undefined')
					theme_support = 'disable';

				if(selector.data('multi-color-overlay'))
				{
					multi_color_overlay = selector.data('multi-color-overlay');
					multi_color_overlay_opacity = selector.data('multi-color-overlay-opacity');
				}

				//vc = parseFloat(vc);
				if(is_vc_4_4 == true || theme_support == 'enable')
				{
					if(selector.prev().is('p') || selector.prev().is('style'))
						var parent = selector.prev().prev();
					else
						var parent = selector.prev();
				}
				else
				{
					var parent = selector.prevAll('.'+vc_row_class+':first');
				}
				parent.css('position','relative');

				var current_row_classes = parent.attr('class'); // for browser full dimension and 4.9 compatible

				selector.remove();

				var overlay_html = overlay_color_html = overlay_pattern_html = overlay_multi_color_html = overlay_pattern_attachment_css = '';

				if(typeof overlay != 'undefined' && overlay.toString() === 'true'){
					if(overlay_pattern != '')
					{
						if(overlay_pattern_size != '')
							overlay_pattern_size = 'background-size:'+overlay_pattern_size+'px;';
						if(typeof overlay_pattern_attachment != 'undefined' && overlay_pattern_attachment != '')
							overlay_pattern_attachment_css = 'background-attachment:'+overlay_pattern_attachment+';';
						overlay_pattern_html = '<div class="upb_bg_overlay_pattern" style="background-image:url('+overlay_pattern+'); opacity:'+overlay_pattern_opacity+'; '+overlay_pattern_size+'; '+overlay_pattern_attachment_css+'"></div>';
					}
					if(overlay_color != '')
						overlay_color_html = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+';"></div>';

					if(multi_color_overlay != '')
						overlay_multi_color_html = '<div class="upb_bg_overlay '+multi_color_overlay+'" style="opacity:'+multi_color_overlay_opacity+';"></div>';

					overlay_html = overlay_color_html+overlay_pattern_html+overlay_multi_color_html;
				}

				if(ride == "browser_size")
				{
					parent.wrapInner('<div class="upb-background-text-wrapper"><div class="upb-background-text"></div></div>');
					parent.find('.upb-background-text-wrapper').find('.upb-background-text').addClass(current_row_classes);
					parent.addClass('full-browser-size');
				}

				if(parallax_content == 'parallax_content_value')
				{
					parent.addClass('vc-row-translate');
					parent.attr('data-parallax-content-sense', parallax_content_sense);
					parent.wrapInner('<div class="vc-row-translate-wrapper '+current_row_classes+'"></div>');
					var ptop = parent.css('padding-top');
					var pbottom = parent.css('padding-bottom');
					parent.find('.vc-row-translate-wrapper').css({'padding-top':ptop, 'padding-bottom':pbottom});
					parent[0].style.setProperty( 'padding-top', '0px', 'important' );
					parent[0].style.setProperty( 'padding-bottom', '0px', 'important' );
				}

				// hide row
				if(hide_row != '')
				{
					parent.addClass('ult-vc-hide-row');
					parent.attr('data-hide-row', hide_row);
				}

				//rtl
				parent.attr('data-rtl', rtl);

				parent.prepend('<div class="upb_row_bg">'+overlay_html+'</div>');
				//selector.remove();

				/* seprators here */
				ult_vc_seperators(selector, parent);

				selector = parent;

				selector.attr('data-row-effect-mobile-disable',disble_mobile);
				if(fadeout == 'fadeout_row_value')
				{
					selector.addClass('vc-row-fade');
					selector.attr('data-fadeout-percentage',fadeout_percentage);
				}

				selector.css('background-image','');
				selector = selector.find('.upb_row_bg');
				selector.attr('data-upb_br_animation',anim_style);
				grad = grad.replace('url(data:image/svg+xml;base64,','');
				var e_pos = grad.indexOf(';');
				grad = grad.substring(e_pos+1);
				selector.attr('style',grad);

				selector.attr('data-bg-override',ride);
				if(ride == 'browser_size')
					selector.parent().find('.upb-background-text-wrapper').addClass('full-browser-size');

				var resize = function(){
					var w,h,ancenstor,al,bl;
					ancenstor = selector.parent();
					if(ride=='full'){
						ancenstor= jQuery('body');
						al=0;
					}
					if(ride=='ex-full'){
						ancenstor= jQuery('html');
						al=0;
					}
					if( ! isNaN(ride)){
						for(var i=0;i<ride;i++){
							if(ancenstor.prop("tagName")!='HTML'){
								ancenstor = ancenstor.parent();
							}else{
								break;
							}
						}
						al = ancenstor.offset().left;
					}
					wh = jQuery(window).height();
					h = selector.parent().outerHeight();
					w = ancenstor.outerWidth();
					selector.css({'min-width':w+'px'});
					bl = selector.offset().left;
					selector.css({'left':-(Math.abs(al-bl))+'px'});
					if(ride=='browser_size'){
						var fbh = selector.parent().find('.upb-background-text').height();
						if(fbh > wh)
							wh = fbh;
						selector.parent().css('height',wh+'px');
						selector.parent().find('.upb-background-text-wrapper').css('height',wh+'px');
					}
				}
				resize();
				jQuery(window).load(function(){
					resize();
				});
				jQuery(window).resize(function(){
					resize();
				});
			})
			return this;
		}
		jQuery.fn.ultimate_bg_color_shift = function() {
			jQuery(this).each(function(){
				var selector = jQuery(this);
				var ride = jQuery(this).data('bg-override');
				var bg_color = jQuery(this).data('bg-color');
				var fadeout = selector.data('fadeout');
				var fadeout_percentage = selector.data('fadeout-percentage');
				var parallax_content = selector.data('parallax-content');
				var parallax_content_sense = selector.data('parallax-content-sense');
				var disble_mobile = selector.data('row-effect-mobile-disable');
				var overlay = selector.data('overlay');
				var overlay_color = selector.data('overlay-color');
				var overlay_pattern = selector.data('overlay-pattern');
				var overlay_pattern_opacity = selector.data('overlay-pattern-opacity');
				var overlay_pattern_size = selector.data('overlay-pattern-size');
				var overlay_pattern_attachment = selector.data('overlay-pattern-attachment');
				var hide_row = selector.data('hide-row');
				var rtl = selector.data('rtl');
				var multi_color_overlay = '';
				var multi_color_overlay_opacity = '';
				var vc = selector.data('vc');
				var theme_support = selector.data('theme-support');
				var vc_row_class = selector.data('custom-vc-row');
				var is_vc_4_4 = selector.data('is_old_vc');

				if(typeof vc_row_class === 'undefined' || vc_row_class === '')
					vc_row_class = 'wpb_row';

				if(typeof vc === 'undefined')
					vc = 0;

				if(typeof is_vc_4_4 === 'undefined')
					is_vc_4_4 = false;

				if(typeof theme_support === 'undefined')
					theme_support = 'disable';

				if(selector.data('multi-color-overlay'))
				{
					multi_color_overlay = selector.data('multi-color-overlay');
					multi_color_overlay_opacity = selector.data('multi-color-overlay-opacity');
				}

				//vc = parseFloat(vc);
				//vc = vc.toFixed(2)

				if(is_vc_4_4 == true || theme_support == 'enable')
				{
					if(selector.prev().is('p') || selector.prev().is('style'))
						var parent = selector.prev().prev();
					else
						var parent = selector.prev();
				}
				else
				{
					var parent = selector.prevAll('.'+vc_row_class+':first');
				}
				parent.css('position','relative');

				var current_row_classes = parent.attr('class'); // for browser full dimension and 4.9 compatible

				var overlay_html = overlay_color_html = overlay_pattern_html = overlay_multi_color_html = overlay_pattern_attachment_css = '';

				if(typeof overlay != 'undefined' && overlay.toString() === 'true'){
					if(overlay_pattern != '')
					{
						if(overlay_pattern_size != '')
							overlay_pattern_size = 'background-size:'+overlay_pattern_size+'px;';
						if(typeof overlay_pattern_attachment != 'undefined' && overlay_pattern_attachment != '')
							overlay_pattern_attachment_css = 'background-attachment:'+overlay_pattern_attachment+';';
						overlay_pattern_html = '<div class="upb_bg_overlay_pattern" style="background-image:url('+overlay_pattern+'); opacity:'+overlay_pattern_opacity+'; '+overlay_pattern_size+'; '+overlay_pattern_attachment_css+'"></div>';
					}
					if(overlay_color != '')
						overlay_color_html = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+';"></div>';

					if(multi_color_overlay != '')
						overlay_multi_color_html = '<div class="upb_bg_overlay '+multi_color_overlay+'" style="opacity:'+multi_color_overlay_opacity+';"></div>';

					overlay_html = overlay_color_html+overlay_pattern_html+overlay_multi_color_html;
				}

				if(ride == "browser_size")
				{
					parent.wrapInner('<div class="upb-background-text-wrapper"><div class="upb-background-text"></div></div>');
					parent.find('.upb-background-text-wrapper').find('.upb-background-text').addClass(current_row_classes);
				}
				else
					var brw_text_wrapper = '';

				// hide row
				if(hide_row != '')
				{
					parent.addClass('ult-vc-hide-row');
					parent.attr('data-hide-row', hide_row);
				}

				// rtl
				parent.attr('data-rtl', rtl);

				if(parallax_content == 'parallax_content_value')
				{
					parent.addClass('vc-row-translate');
					parent.wrapInner('<div class="vc-row-translate-wrapper '+current_row_classes+'"></div>');
					parent.attr('data-parallax-content-sense', parallax_content_sense);
					var ptop = parent.css('padding-top');
					var pbottom = parent.css('padding-bottom');
					parent.find('.vc-row-translate-wrapper').css({'padding-top':ptop, 'padding-bottom':pbottom});
					parent[0].style.setProperty( 'padding-top', '0px', 'important' );
					parent[0].style.setProperty( 'padding-bottom', '0px', 'important' );
				}

				parent.prepend('<div class="upb_row_bg">'+overlay_html+'</div>');

				/* seprators here */
				ult_vc_seperators(selector, parent);

				selector.remove();
				selector = parent;

				selector.attr('data-row-effect-mobile-disable',disble_mobile);
				if(fadeout == 'fadeout_row_value')
				{
					selector.addClass('vc-row-fade');
					selector.attr('data-fadeout-percentage',fadeout_percentage);
				}

				selector.css('background-image','');
				selector = selector.find('.upb_row_bg');
				selector.css({'background':bg_color});
				selector.attr('data-bg-override',ride);
				if(ride == 'browser_size')
					selector.parent().find('.upb-background-text-wrapper').addClass('full-browser-size');

				var resize = function(){
					var w,h,ancenstor,al,bl;
					ancenstor = selector.parent();
					if(ride=='full'){
						ancenstor= jQuery('body');
						al=0;
					}
					if(ride=='ex-full'){
						ancenstor= jQuery('html');
						al=0;
					}
					if( ! isNaN(ride)){
						for(var i=0;i<ride;i++){
							if(ancenstor.prop("tagName")!='HTML'){
								ancenstor = ancenstor.parent();
							}else{
								break;
							}
						}
						al = ancenstor.offset().left;
					}
					wh = jQuery(window).height();
					h = selector.parent().outerHeight();
					w = ancenstor.outerWidth();
					selector.css({'min-width':w+'px'});
					bl = selector.offset().left;
					selector.css({'left':-(Math.abs(al-bl))+'px'});
					if(ride=='browser_size'){
						var fbh = selector.parent().find('.upb-background-text').height();
						if(fbh > wh)
							wh = fbh;
						selector.parent().css('height',wh+'px');
						selector.parent().find('.upb-background-text-wrapper').css('height',wh+'px');
					}
				}
				resize();
				jQuery(window).load(function(){
					resize();
				});
				jQuery(window).resize(function(){
					resize();
				});
			})
			return this;
		}
		jQuery.fn.ultimate_parallax_animation = function(applyTo) {
			var windowHeight = jQuery(window).height();
			var getHeight = function(obj) {
					return obj.height();
				};
			var $this = jQuery(this);
			var prev_pos = jQuery(window).scrollTop();
			function updata(){
				var firstTop;
				var paddingTop = 0;
				var pos = jQuery(window).scrollTop();
				$this.each(function(){
					if(jQuery(this).data('upb_br_animation')=='upb_fade_animation'){
						firstTop = jQuery(this).offset().top;
						var $element = jQuery(this);
						var top = $element.offset().top;
						var height = getHeight($element);
						if (top + height < pos || top > pos + windowHeight-100) {
							return;
						}
						var pos_change = prev_pos-pos;
						if ((top+height)-windowHeight < pos) {
							var op_c = (pos_change/windowHeight);
							if(applyTo=='parent'){
								var op = parseInt(jQuery(this).css('opacity'));
								op += op_c/2.3;
								jQuery(this).parents('.wpb_row').css({opacity :op})
							}
							if(applyTo=='self'){
								var op = parseInt(jQuery(this).css('opacity'));
								op += op_c/2.3;
								jQuery(this).css({opacity :op})
							}
						}
						prev_pos = pos;
					}
				});
			}
			jQuery(window).bind('scroll', updata).resize(updata);
			updata();
		}

		 var temp_vdo_pos = 0;

			if(jQuery('.upb_content_video, .upb_content_iframe').prev().is('p'))
				jQuery('.upb_content_video, .upb_content_iframe').prev().prev().css('background-image','').css('background-repeat','');
			else
				jQuery('.upb_content_video, .upb_content_iframe').prev().css('background-image','').css('background-repeat','');

			jQuery('.upb_content_video').ultimate_video_bg();
			jQuery('.upb_bg_img').ultimate_bg_shift();
			jQuery('.upb_content_iframe').ultimate_video_bg();
			jQuery('.upb_grad').ultimate_grad_shift();
			jQuery('.upb_color').ultimate_bg_color_shift();

			jQuery('.upb_no_bg').each(function(index, nobg) {

				var no_bg_fadeout = jQuery(nobg).attr('data-fadeout');
				var fadeout_percentage = jQuery(nobg).data('fadeout-percentage');
				var parallax_content = jQuery(nobg).data('parallax-content');
				var parallax_content_sense = jQuery(nobg).data('parallax-content-sense');

				var disble_mobile = jQuery(nobg).data('row-effect-mobile-disable');

				var vc_row_class = jQuery(nobg).data('custom-vc-row');
				var vc = jQuery(nobg).data('vc');
				var theme_support = jQuery(nobg).data('theme-support');

				if(typeof vc_row_class === 'undefined' || vc_row_class === '')
					vc_row_class = 'wpb_row';

				if(typeof vc === 'undefined')
					vc = 0;

				if(typeof theme_support === 'undefined')
					theme_support = 'disable';

				vc = parseFloat(vc);
				if(vc < 4.4 || theme_support == 'enable')
				{
					if(jQuery(nobg).prev().is('p') || jQuery(nobg).prev().is('style'))
						var parent = jQuery(nobg).prev().prev();
					else
						var parent = jQuery(nobg).prev();
				}
				else
				{
					var parent = jQuery(nobg).prevAll('.'+vc_row_class+':first');
				}
				parent.css('position','relative');

				if(typeof parent[0] === 'undefined')
					return false;

				parent.attr('row-effect-mobile-disable',disble_mobile);

				if(no_bg_fadeout == 'fadeout_row_value')
				{
					parent.addClass('vc-row-fade');
					parent.data('fadeout-percentage',fadeout_percentage);
				}
				if(parallax_content == 'parallax_content_value')
				{
					parent.addClass('vc-row-translate');
					parent.attr('data-parallax-content-sense', parallax_content_sense);

					parent.wrapInner('<div class="vc-row-translate-wrapper"></div>');
					var ptop = parent.css('padding-top');
					var pbottom = parent.css('padding-bottom');
					parent.find('.vc-row-translate-wrapper').css({'padding-top':ptop, 'padding-bottom':pbottom});
					parent[0].style.setProperty( 'padding-top', '0px', 'important' );
					parent[0].style.setProperty( 'padding-bottom', '0px', 'important' );
				}
			});
			jQuery('.upb_no_bg').remove();

			var resizees = function(){
				jQuery('.upb_row_bg').each(function() {
					var ride = jQuery(this).data('bg-override');
					var theme_support = jQuery(this).data('theme-support');
					var vc_row = jQuery(this).data('row');

					var ancenstor,parent;

					if(typeof theme_support !== 'undefined' && theme_support !== 'enable')
						parent = jQuery(this).parents('.'+vc_row+':first');
					else
						parent = jQuery(this).parent();

					parent.addClass('vc_row-has-fill');

					if(ride=='browser_size'){
						ancenstor=jQuery('html');
					}
					if(ride == 'ex-full'){
						ancenstor = jQuery('html');
					}
					else if(ride == 'full'){
						ancenstor = jQuery('body');
					}

					else if(! isNaN(ride)){
						ancenstor = parent;
						for ( var i = 0; i < ride; i++ ) {
							if ( ancenstor.is('html') ) {
								break;
							}
							ancenstor = ancenstor.parent();
						}
					}
					var al= parseInt( ancenstor.css('paddingLeft') );
					var ar= parseInt( ancenstor.css('paddingRight') )
					var w = al+ar + ancenstor.width();
					var bl = - ( parent.offset().left - ancenstor.offset().left );
					if ( bl > 0 ) {	left = 0; }
					jQuery(this).css({'width': w,'left': bl	})
					if(ride=='browser_size'){
						var a_width = ancenstor.width();
						var a_height = ancenstor.height();
						var p_width = parent.width();
						var p_height = parent.height();

						var rheight = parent.find('.upb-background-text').height();
						var w_height = jQuery(window).height();
						if(rheight > p_height)
							var m_height = rheight;
						else
							var m_height = w_height;

						parent.css('min-height',m_height+'px');
						parent.find('.upb-background-text-wrapper').css('min-height',m_height+'px');
					}
				});

				jQuery('.upb_video-bg').each(function(index,ele) {
					var ride = jQuery(this).data('bg-override');
					var rtl = jQuery(this).attr('data-rtl');
					var theme_support = jQuery(this).data('theme-support');
					var vc_row = jQuery(this).data('row');

					var ancenstor,parent;

					if(typeof theme_support !== 'undefined' && theme_support !== 'enable')
						parent = jQuery(this).parents('.'+vc_row+':first');
					else
						parent = jQuery(this).parent();

					if(parent.attr('data-vc-full-width') == 'true' || parent.attr('data-vc-full-width') == true) {
						parent.addClass('uvc-vc-full-width');
					} else {
						parent.addClass('uvc-row');
					}

					if(ride=='browser_size'){
						ancenstor=jQuery('html');
						jQuery(this).parents('.upb_video_class').css('overflow','visible');

					}
					else if(ride == 'ex-full'){
						ancenstor = jQuery('html');
						jQuery(this).parents('.upb_video_class').css('overflow','visible');
					}
					else if(ride == 'full'){
						ancenstor = jQuery('body');
						jQuery(this).parents('.upb_video_class').css('overflow','visible');
					}
					else if(! isNaN(ride) && ride != 0){
						ancenstor = parent;
						for ( var i = 1; i <= ride; i++ ) {
							if ( ancenstor.is('html') ) {
								break;
							}
							ancenstor = ancenstor.parent();
						}
					}
					else
						ancenstor = parent;

					var al= parseInt( ancenstor.css('paddingLeft') );
					var ar= parseInt( ancenstor.css('paddingRight') );
					var vc_margin = parseInt( ancenstor.css('marginLeft') ); //vc row margin
					var w = ancenstor.outerWidth();
					var wx = w;
					var vdo_left = jQuery(this).offset().left;
					//jQuery(this).css('left','initial');
					var vdo_left_pos = jQuery(this).position().left;
					var div_left = ancenstor.offset().left;
					var cal_left = div_left - vdo_left;
					if(vdo_left_pos < 0)
						cal_left = vdo_left_pos + cal_left;

					if(index == 0)
						temp_vdo_pos = vdo_left_pos;
					if(temp_vdo_pos > 0)
						cal_left = temp_vdo_pos;

					//if(ride == 'full' || ride == 'ex-full' || ride=='browser_size') {
						if(cal_left > 0)
							cal_left = 0;
					//}

					if(typeof rtl !== 'undefined' && (rtl === true || rtl === 'true'))
						jQuery(this).css({'width': w,'min-width':w,'right': cal_left });
					else
						jQuery(this).css({'width': w,'min-width':w,'left': cal_left });
					var ratio =(16/9);

					var w_width = jQuery(window).width();
					var w_height = jQuery(window).height();
					var v_height = parent.find('video').height();

					if(ride=='browser_size')
						var rheight = parent.find('.upb_video-text').height();
					else
						var rheight = parent.height();

					if(w < 960)
					{
						var rvdh = (16/9)*rheight;
						w = rvdh + w;
					}
					//if(rheight > w_height)
					//	w = rheight+rheight;

					pHeight = Math.ceil(w / ratio);
					children = jQuery(this).children();

					children.removeClass('ult-make-full-height');

					if(rheight > wx)
						children.addClass('ult-make-full-height');

					//children.css({'width': w,'min-width':w});

					var is_poster = jQuery(this).css('background-image');

					if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
					{
						//children.css({'height':pHeight});
						if(ride=='browser_size'){
							if(rheight > w_height)
								var m_height = rheight;
							else
								var m_height = w_height;
							parent.addClass('video-browser-size');
							parent.find('.upb-background-text-wrapper').addClass('full-browser-size');
							parent.css('min-height',m_height+'px');

							if(parent.find('.upb_video-text-wrapper').length > 0)
							{
								parent.find('.upb_video-text-wrapper').addClass('full-browser-size');
								parent.find('.upb_video-text-wrapper').css('min-height',m_height+'px');
							}
						}
					}
					else
					{
						if(typeof is_poster === 'undefined' || is_poster == 'none')
						{
							children.css({'max-height':'auto','height':'auto'});
							parent.css('min-height','auto');
						}
					}
				});
			};
			resizees();
			//jQuery('.upb_video-bg').parents('.upb_video_class').css('overflow','visible');
			jQuery(window).load(function(){
				resizees();
				resize_ult_seperators();
			});
			jQuery(window).resize(function(){
				resizees();
				resize_ult_seperators();
			});

			// ajax fallback
			jQuery(document).ajaxComplete(function(e, xhr, settings){
				if(jQuery('.upb_content_video, .upb_content_iframe').prev().is('p'))
					jQuery('.upb_content_video, .upb_content_iframe').prev().prev().css('background-image','').css('background-repeat','');
				else
					jQuery('.upb_content_video, .upb_content_iframe').prev().css('background-image','').css('background-repeat','');

				jQuery('.upb_content_video').ultimate_video_bg();
				jQuery('.upb_bg_img').ultimate_bg_shift();
				jQuery('.upb_content_iframe').ultimate_video_bg();
				jQuery('.upb_grad').ultimate_grad_shift();
				jQuery('.upb_color').ultimate_bg_color_shift();
			});

			jQuery('.video-controls').click(function(e) {
				var current_action = jQuery(this).attr('data-action');

				var vdo = jQuery(this).parent().find('.upb_video-src');
				if(current_action == 'pause')
				{
					jQuery(this).attr('data-action','play');
					vdo[0].play();
					jQuery(this).html('<i class="ult-vid-cntrlpause"></i>');
				}
				else
				{
					jQuery(this).attr('data-action','pause');
					vdo[0].pause();
					jQuery(this).html('<i class="ult-vid-cntrlplay"></i>');
				}

				if(vdo.hasClass('enable-on-viewport'))
				{
					vdo.addClass('override-controls');
				}
			});

			/* hide row */
			check_for_hide_row();
			function check_for_hide_row()
			{
				jQuery('.ult-vc-hide-row').each(function(i,row){
					var hide_classes = jQuery(row).data('hide-row');
					if(hide_classes != '')
						jQuery(row).addClass(hide_classes);
				});
			}

			/* use for full width seperator */
			resize_ult_seperators();
			function resize_ult_seperators()
			{
				jQuery('.ult-vc-seperator').each(function(i,s) {
					var full_width = jQuery(this).data('full-width');
					var is_rtl = jQuery(this).parent().data('rtl');

					if(typeof is_rtl == 'undefined')
						is_rtl = 'false';

					var override = jQuery(this).parent().find('.upb_row_bg').data('bg-override');
					if(typeof override == 'undefined')
						var override = jQuery(this).parent().find('.upb_video-bg').data('bg-override');

					if((override == 'ex-full' || override == 'full' || override == 'browser_size') && full_width == true)
					{
						var win = jQuery('html').width();

						if(jQuery(this).hasClass('ult-rounded-split-seperator-wrapper'))
						{
							var border = jQuery(this).data('border');
							var border_width = jQuery(this).data('border-width');
							if(typeof border != 'undefined' && border!='none' && border != 'undefined')
								win = win - border_width;
						}

						var left = jQuery(this).offset().left;
						jQuery(this).find('.ult-main-seperator-inner').width(win);
						if(is_rtl.toString() == 'true')
							jQuery(this).find('.ult-main-seperator-inner').css({'margin-right':-left+'px'});
						else
							jQuery(this).find('.ult-main-seperator-inner').css({'margin-left':-left+'px'});
					}
				});
			}

			//row animation execution
			jQuery('.vcpb-animated').each(function(index, element) {
				var repeat = jQuery(element).data('animation-repeat');
				jQuery(this).css({'background-repeat':repeat});
				var mobile_disable = jQuery(element).parent().attr('data-img-parallax-mobile-disable');
				if(typeof mobile_disable == "undefined")
					mobile_disable = 'false';
				else
					mobile_disable = mobile_disable.toString();
				if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
					var is_mobile = 'false';
				else
					var is_mobile = 'true';
				if(is_mobile == 'true' && mobile_disable == 'true')
					var disable_row_effect = 'true';
				else
					var disable_row_effect = 'false';
				if(disable_row_effect == 'false')
				{
					var scrollSpeed = 10;
					if(jQuery(this).attr('data-parallax_sense') != '')
						scrollSpeed = jQuery(this).attr('data-parallax_sense');

					scrollSpeed = 100 - scrollSpeed;

					var animation_type = jQuery(this).attr('data-bg-animation-type');
					var animation = jQuery(this).attr('data-bg-animation');

					// set the default position
					var current = 0;
					// set the direction
					var direction = animation_type;
					//Calls the scrolling function repeatedly
					setInterval(function(e){
						if(animation == 'right-animation' || animation == 'bottom-animation')
							current -= 1;
						else
							current += 1;
						jQuery(element).css("backgroundPosition", (direction == 'h') ? current+"px 0" : "0 " + current+"px");
					}, scrollSpeed);
				}
			});
	 });
 }( jQuery ));