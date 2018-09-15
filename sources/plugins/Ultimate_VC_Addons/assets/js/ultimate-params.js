jQuery(document).ready(function($) {
	
	/**
	 * 	init variables
	 */
	 var 	large_screen		= '',
			desktop				= '',
			tablet				= '',
			tablet_portrait		= '',
			mobile_landscape	= '',
			mobile				= '';

	/**
	 * 	generate responsive @media css
	 *------------------------------------------------------------*/
	jQuery(".ult-responsive").each(function(index, element) {

		var t 						= jQuery(this),
			n 						= t.attr('data-responsive-json-new'),
			target 					= t.data('ultimate-target'),
			temp_large_screen		= '',
			temp_desktop			= '',
			temp_tablet				= '',
			temp_tablet_portrait	= '',
			temp_mobile_landscape	= '',
			temp_mobile				= '';

		if (typeof n != "undefined" || n != null) {
			$.each($.parseJSON(n), function (i, v) {
				// set css property
				var css_prop = i;
			   	if (typeof v != "undefined" && v != null) {
					var vals = v.split(";");
				  	jQuery.each(vals, function(i, vl) {
				  		if (typeof vl != "undefined" || vl != null) {
				            var splitval = vl.split(":");
							switch(splitval[0]) {
								case 'large_screen':  	temp_large_screen		+= css_prop+":"+splitval[1]+";"; break;
								case 'desktop': 		temp_desktop			+= css_prop+":"+splitval[1]+";"; break;
								case 'tablet': 			temp_tablet				+= css_prop+":"+splitval[1]+";"; break;
								case 'tablet_portrait': temp_tablet_portrait	+= css_prop+":"+splitval[1]+";"; break;
								case 'mobile_landscape':temp_mobile_landscape	+= css_prop+":"+splitval[1]+";"; break;
								case 'mobile': 			temp_mobile				+= css_prop+":"+splitval[1]+";"; break;
							}
						}
					});					
				}
			});
		}

		/*	
		 *		REMOVE Comments for TESTING
		 *-------------------------------------------*/
		//if(temp_mobile!='') { 			mobile				+= '\n\t'+ target+ " { \t\t"+temp_mobile+" \t}"; }
		//if(temp_mobile_landscape!='') { mobile_landscape	+= '\n\t'+ target+ " { \t\t"+temp_mobile_landscape+" \t}"; }
		//if(temp_tablet_portrait!='') { tablet_portrait		+= '\n\t'+ target+ " { \t\t"+temp_tablet_portrait+" \t}"; }
		//if(temp_tablet!='') { 			tablet				+= '\n\t'+ target+ " { \t\t"+temp_tablet+" \t}"; }
		//if(temp_desktop!='') { 			desktop				+= '\n\t'+ target+ " { \t\t"+temp_desktop+" \t}"; }
		//if(temp_large_screen!='') { 	large_screen		+= '\n\t'+ target+ " { \t\t"+temp_large_screen+" \t}"; }

		if(temp_mobile!='') { 			mobile				+= target+ '{'+temp_mobile+'}'; }
		if(temp_mobile_landscape!='') { mobile_landscape	+= target+ '{'+temp_mobile_landscape+'}'; }
		if(temp_tablet_portrait!='') { tablet_portrait		+= target+ '{'+temp_tablet_portrait+'}'; }
		if(temp_tablet!='') { 			tablet				+= target+ '{'+temp_tablet+'}'; }
		if(temp_desktop!='') { 			desktop				+= target+ '{'+temp_desktop+'}'; }
		if(temp_large_screen!='') { 	large_screen		+= target+ '{'+temp_large_screen+'}'; }
	});

/*	
 *		REMOVE Comments for TESTING
 *-------------------------------------------*/
//var UltimateMedia 	 = '<style>\n/** Ultimate: Media Responsive **/ ';
//	UltimateMedia	+= desktop;
//	UltimateMedia	+= "\n@media (min-width: 1824px) { "+ large_screen 		+"\n}";
//	UltimateMedia	+= "\n@media (max-width: 1199px) { "+ tablet 			+"\n}";
//	UltimateMedia	+= "\n@media (max-width: 991px)  { "+ tablet_portrait 	+"\n}";
//	UltimateMedia	+= "\n@media (max-width: 767px)  { "+ mobile_landscape 	+"\n}";
//	UltimateMedia	+= "\n@media (max-width: 479px)  { "+ mobile 			+"\n}";
//	UltimateMedia	+= '\n/** Ultimate: Media Responsive - **/</style>';	
//	jQuery('head').append(UltimateMedia);
//	//console.log(UltimateMedia);

var UltimateMedia 	 = '<style>/** Ultimate: Media Responsive **/ ';
	UltimateMedia	+= desktop;
	/*UltimateMedia	+= "@media (min-width: 1824px) { "+ large_screen 		+"}";*/
	UltimateMedia	+= "@media (max-width: 1199px) { "+ tablet 				+"}";
	UltimateMedia	+= "@media (max-width: 991px)  { "+ tablet_portrait 	+"}";
	UltimateMedia	+= "@media (max-width: 767px)  { "+ mobile_landscape 	+"}";
	UltimateMedia	+= "@media (max-width: 479px)  { "+ mobile 				+"}";
	UltimateMedia	+= '/** Ultimate: Media Responsive - **/</style>';	
	jQuery('head').append(UltimateMedia);
	//console.log(UltimateMedia);

});