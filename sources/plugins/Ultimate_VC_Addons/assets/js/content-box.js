;(function ( $, window, undefined ) {

	jQuery(window).load(function(a){
		contentBoxInit();
	});
	jQuery(window).resize(function(a){
		contentBoxInit();
	});
	jQuery(document).ready(function(a) {
		contentBoxInit();
	});

	//	Content Box - Initialize
	function contentBoxInit() {
		$('.ult-content-box').each(function(index, el) {
			var normal_bg_color = $(el).css('background-color') || '';
			var normal_border_color = $(el).data('border_color') || 'transparent';
			var normal_box_shadow = $(el).css('box-shadow') || '';

			var hover_bg_color = $(el).data('hover_bg_color') || $(el).css('background-color');
			var hover_border_color = $(el).data('hover_border_color') || 'transparent';
			var hover_box_shadow = $(el).data('hover_box_shadow') || $(el).css('box-shadow');

			$(el).hover(function() {
				$(el).css('background-color', hover_bg_color);
				$(el).css('border-color', hover_border_color);
				$(el).css('box-shadow', hover_box_shadow);
			}, function() {
				$(el).css('background-color', normal_bg_color);
				$(el).css('border-color', normal_border_color);
				$(el).css('box-shadow', normal_box_shadow);
			});

			//	Margins - 	Responsive
			var rm_o = {};
			var rm = $(el).data('responsive_margins');
			if(typeof rm != 'undefined' && rm != null) {
				rm_o = getMargins(rm);
			}

			//	Margins - 	Normal
			var nm_o = {};
			var nm = $(el).data('normal_margins');
			if(typeof nm != 'undefined' && nm != null ) {
				nm_o = getMargins(nm);
			} else {
				nm_o = getCssMargins(el);
			}

			var WW = $(window).width() || '';
			if(WW!='') {
				if(WW>=768) {
					//console.log('TRUE >= 768');
					applyMargins(nm_o, el);
				} else {
					//console.log('FALSE not >= 768');
					applyMargins(rm_o, el);
				}
			}

		});
	}
	//	create an object
	function getCssMargins(el) {
		var tmOb = {};
		tmOb['margin-left'] = trimPx($(el).css('margin-left'));
		tmOb['margin-right'] = trimPx($(el).css('margin-right'));
		tmOb['margin-top'] = trimPx($(el).css('margin-top'));
		tmOb['margin-bottom'] = trimPx($(el).css('margin-bottom'));

		//	Create normal margins
		var bs = '';
		$.each(tmOb, function(index, val) {
			if(typeof val!= 'undefined' && val != null) {
				bs += index+':'+val+'px;';
			}
		});
		$(el).attr('data-normal_margins', bs);
		return tmOb;
	}
	//	Trim 'px' from margin val
	function trimPx(l) {
		var sp;
		if(typeof l != 'undefined' && l != null) {
			sp = l.split('px');
			sp = parseInt(sp[0])
		}
		return sp;
	}

	//	Get margins from - DATA ATTRIBUTE
	//	@return object
	function getMargins(mo) {
		var tmOj = {};
		var b = mo.split(';');
		if(typeof b != 'undefined' && b != null ) {
			$.each(b, function(index, val) {
				if(typeof val != undefined && val != null) {
					var nm = val.split(':');
					if(typeof nm[0] != undefined && nm[0] != null && typeof nm[1] != undefined && nm[1] != null ) {
						switch(nm[0]) {
							case 'margin' : 	tmOj['margin'] = (nm[1]);
								break;
							case 'margin-left' :  	tmOj['margin-left'] = (nm[1]);
								break;
							case 'margin-right' : 	tmOj['margin-right'] = (nm[1]);
								break;
							case 'margin-top' : 	tmOj['margin-top'] = (nm[1]);
								break;
							case 'margin-bottom' : 	tmOj['margin-bottom'] = (nm[1]);
								break;
						}
					}
				}
			});
		}
		return tmOj;
	}

	//	Apply css margins from object
	//	@return null
	function applyMargins(ob, el) {
		if( !$.isEmptyObject(ob) ) {
			$.each(ob, function(index, val) {
				if(typeof val!= 'undefined' && val != null) {
					$(el).css(index, val);
				}
			});
		}
	}


}(jQuery, window));