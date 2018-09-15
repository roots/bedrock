!function($) {
	$('.ultimate_google_font_param_block > select').each(function(index, element) {
        $select = $(this);
		var random_num = Math.floor((Math.random() * 10000000) + index);
		process_vc_gfont_fields($select, random_num, change = 'false');
    });
	$('.ultimate_google_font_param_block > select').change(function(e){
		e.preventDefault();
		var random_num = Math.floor((Math.random() * 10000000) + 1);
		process_vc_gfont_fields($(this), random_num , change = 'true');
	});
	$('body').on('click', '.ugfont-input', function () {
		var font_style = '';
		var temp_chk = 0;
		$fstyle = $(this).parent('.ultimate_fstyle').parent();
		var tmp_array = new Array();
		$fstyle.find('.ugfont-input').each(function (index, checkbox) {
			if ($(this).is(':checked')) {
				var val = $(this).val();
				tmp_array.push(val);
			}
		});
		var font_style = '';
		$.each(tmp_array,function (index, value) {
			if (index != 0) {
				font_style += ',';
			}
			font_style += value;
		});
		$fstyle.find('.ugfont-style-value').val(font_style);
	});
	$('body').on('click', '.style_by_google', function(){
		var variant = $(this).attr('data-variant');
		if($(this).is(':checked'))
		{
			var wpb_el_type_ultimate_google_fonts_style = $(this).parents('.wpb_el_type_ultimate_google_fonts_style');
			var wpb_el_type_ultimate_google_fonts = wpb_el_type_ultimate_google_fonts_style.prev();
			var vc_ultimate_google_font = wpb_el_type_ultimate_google_fonts.find('.vc-ultimate-google-font').val();
			var split_font = vc_ultimate_google_font.split('|'); //font_family=xyz|font_call=xyz:100,200
			var font_family = split_font[0]; //font_family=xyz
			var font_call = split_font[1]; //font_call=xyz
			var new_font = font_family+'|'+font_call+'|variant:'+variant;
			wpb_el_type_ultimate_google_fonts.find('.vc-ultimate-google-font').val(new_font);
		}
	});
}(window.jQuery);
var temp_count = 0;
function process_vc_gfont_fields($select, random_num, is_font_change)
{
	var ultimate_vc_gfonts_field = $select.parents('.wpb_el_type_ultimate_google_fonts');
	var vc_ultimate_google_font = ultimate_vc_gfonts_field.find('.vc-ultimate-google-font');
	var vc_ultimate_google_font_val = vc_ultimate_google_font.val();
	var val = '';
	if(is_font_change == 'false')
	{
		if(vc_ultimate_google_font_val != '')
		{
			var gfont_name_attr = vc_ultimate_google_font_val.split('|');
			var gfont_name = gfont_name_attr[0].split(':');
			val = gfont_name[1];
			if(val == '')
				val = 'default';
		}
		else
			val = 'default';
			
		$select.find('option').each(function(index, option) {
        	if(jQuery(option).val() == val)
				jQuery(option).attr('selected',true);
    	});
	}
	else
	{
		var val = $select.find('option:selected').val();
		var new_font_call = val.replace(/\s+/g,'+');
		var new_font = 'font_family:'+val+'|font_call:'+new_font_call;
		vc_ultimate_google_font.val(new_font);
	}
	var $next_fstyler = ultimate_vc_gfonts_field.next('.wpb_el_type_ultimate_google_fonts_style').find('.ultimate_fstyle');	
	if(typeof $next_fstyler != "undefined")
	{		
		$next_fstyler.html('<span class="spinner" style="display:inline-block; float:left;margin:0;visibility:visible"></span>');
		var data = {
			action : 'get_font_variants',
			font_name : val
		}
		jQuery.post(ajaxurl, data, function(response) {
			var current_style = '';
			if($next_fstyler.parent().find('.ugfont-style-value'))
				current_style = $next_fstyler.parent().find('.ugfont-style-value').val();
			var temp_array = new Array();
			var is_array = false;
			if (temp_array = split(',',current_style)) {
				is_array = true;
			}
			else {
				if(current_style != '')
					temp_array.push(current_style);
			}
			var html = temp_last_fgroup = '';
			var font_variant = jQuery.parseJSON(response);
			jQuery.each(font_variant, function (index, variant) {
				var flabel = variant.label;
				var fstyle = variant.style;
				var ftype = variant.type;
				var fgroup = variant.group+'-'+temp_count;
				var fclass = variant.class;
				var checked = '';
				if(temp_array.length != 0)
				{
					jQuery.each(temp_array, function (i,v) {
						if (v == fstyle && is_font_change == 'false')
							checked = 'checked';
					});
				}
				var label_style = 'font-family:\''+val+'\';'+fstyle;
				if (fgroup != temp_last_fgroup && temp_last_fgroup != '')
				{
					html += '<div style="height:6px">&nbsp;</div>';
					if(ftype == 'radio')
						html += '<input type="radio" name="'+fgroup+'" data-variant="regular" style="width:auto; margin-left: 5px; margin-right: 2px;" id="uvc-default-font-'+fgroup+'" class="ugfont-input '+fclass+'" checked value="font-weight:normal;font-style:normal;" />&nbsp;<label for="uvc-default-font-'+fgroup+'" style="font-family:\''+val+'\';font-style: normal;">Default</label> &nbsp; ';
				}
				var vl = val.replace(/\s+/g, '-').toLowerCase();
				var uid = vl +'-'+ random_num;
				uid += '-'+flabel+'-'+index;
				if(jQuery('#'+uid).length != 0)
					uid += '-'+$('#'+uid).length;
				html += '<input type="'+ftype+'" data-variant="'+flabel+'" name="'+fgroup+'" style="width:auto; margin-left: 5px; margin-right: 2px;" '+checked+' id="'+uid+'-'+fgroup+'" class="'+fclass+' '+flabel+' ugfont-input" value="'+fstyle+'" />&nbsp;<label for="'+uid+'-'+fgroup+'" style="'+label_style+'">'+flabel+'</label> &nbsp; ';
				temp_last_fgroup = fgroup;
			});
			$next_fstyler.html(html);
		});
		temp_count++;
	}
}
