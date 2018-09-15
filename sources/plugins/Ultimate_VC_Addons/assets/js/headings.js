(function($){
	$jh = $.noConflict();
	$jh(document).ready(function(e) {
		ultimate_headings_init();
		$jh(window).resize(function(e){
			ultimate_headings_init();
		});
	});
	$(window).load(function(e) {
		ultimate_headings_init();
		//trigger on click of exp section
		jQuery(".ult_exp_section").select(function(){
				
				var slength=jQuery(this).parent().find('.uvc-heading').length;
				if(slength>0)
					{
						ultimate_headings_init();
					}
			});
	});
	function ultimate_headings_init()
	{
		var fixer = 0;
		$jh('.uvc-heading').each(function(){ 
			var icon_height, icon_width, line_width;
			var wrapper_width = $jh(this).outerWidth();
			var hline_width = $jh(this).attr('data-hline_width');
			var icon_type = $jh(this).attr('data-hicon_type');
			var align = $jh(this).attr('data-halign');
			var spacer = $jh(this).attr('data-hspacer');
			if(spacer == 'line_with_icon')
			{
				var id = $jh(this).attr('id');
				fixer = $jh(this).attr('data-hfixer');
				if(typeof fixer === 'undefined' || fixer === '')
					fixer = 0;
				else
					fixer = parseInt(fixer);
				var mid_wrapper_width = (wrapper_width/2);
				$jh(this).find('.dynamic_ultimate_heading_css').remove();
				if(hline_width == 'auto' || hline_width>wrapper_width)
					line_width = wrapper_width;
				else
					line_width = hline_width;
				var mid_line_width = line_width/2;
				if(icon_type == 'selector')
				{
					icon_width = $jh(this).find('.aio-icon').outerWidth();
					icon_height = $jh(this).find('.aio-icon').outerHeight();
				}
				else
				{
					icon_width = $jh(this).find('.aio-icon-img').outerWidth();
					icon_height = $jh(this).find('.aio-icon-img').outerHeight();
				}
				
				var mid_icon_width = (icon_width/2);
				
				var line_pos = (mid_wrapper_width - mid_icon_width)+icon_width+fixer;
				var cline_width = mid_line_width;
				/* add 3px extra spacing to fix {crop icon} issue */
				icon_height = icon_height+3;
				$jh(this).find('.uvc-heading-spacer').height(icon_height);
				if(align == 'center')
				{	
					$jh(this).find('.aio-icon-img').css({'margin':'0 auto'});
					var border_css = '#'+id+' .uvc-heading-spacer.line_with_icon:before{right:'+line_pos+'px;}#'+id+' .uvc-heading-spacer.line_with_icon:after{left:'+line_pos+'px;}';
				}
				else if(align == 'left')
				{
					$jh(this).find('.aio-icon-img').css({'float':align});
					var border_css = '';
					if(line_width != '')
					{
						border_css = '#'+id+' .uvc-heading-spacer.line_with_icon:before{left:'+(icon_width+fixer)+'px;right:auto;}#'+id+' .uvc-heading-spacer.line_with_icon:after{left:'+(cline_width+icon_width+fixer)+'px;right:auto;}';
					}
					else
					{
						border_css = '#'+id+' .uvc-heading-spacer.line_with_icon:before{right:'+(line_pos-icon_width-(fixer*2))+'px;}#'+id+' .uvc-heading-spacer.line_with_icon:after{left:'+(line_pos-fixer)+'px;}';
					}
				}
				else if(align == 'right')
				{
					$jh(this).find('.aio-icon-img').css({'float':align});
					var border_css = '';
					if(line_width != '')
					{
						border_css = '#'+id+' .uvc-heading-spacer.line_with_icon:before{right:'+(icon_width+fixer)+'px;left:auto;}#'+id+' .uvc-heading-spacer.line_with_icon:after{right:'+(cline_width+icon_width+fixer)+'px;left:auto;}';
					}
					else
					{
						border_css = '#'+id+' .uvc-heading-spacer.line_with_icon:before{right:'+(line_pos-fixer)+'px;}#'+id+' .uvc-heading-spacer.line_with_icon:after{left:'+(line_pos-icon_width-(fixer*2))+'px;}';
					}
				}
				var border_style = $jh(this).attr('data-hborder_style');
				var border_color = $jh(this).attr('data-hborder_color');
				var border_height = $jh(this).attr('data-hborder_height');
				if(hline_width == 'auto')
				{
					if(align == 'center')
						cline_width = Math.floor(cline_width-icon_width+fixer);
				}
				var hstyle_spacer = '<div class="dynamic_ultimate_heading_css"><style>#'+id+' .uvc-heading-spacer.line_with_icon:before, #'+id+' .uvc-heading-spacer.line_with_icon:after{width:'+(cline_width)+'px;border-style:'+border_style+';border-color:'+border_color+';border-bottom-width:'+border_height+'px;}'+border_css+'</style></div>';
				$jh(this).prepend(hstyle_spacer);
			}
			else if(spacer == 'line_only')
			{				
				if(align == 'right' || align == 'left')
				{
					$jh(this).find('.uvc-heading-spacer').find('.uvc-headings-line').css({'float':align});
				}
				else
				{
					$jh(this).find('.uvc-heading-spacer').find('.uvc-headings-line').css({'margin':'0 auto'});
				}
			}
		});
	}
})(jQuery);