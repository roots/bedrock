(function($) {
	$(document).ready(function(){
		
		$(document).on("mouseenter", ".ultimate-call-to-action", function() {
			$(this).addClass('ultimate-call-to-action-hover');
			var hover = $(this).data('background-hover');
			$(this).css({'background-color':hover});
		});
		
		$(document).on("mouseleave", ".ultimate-call-to-action", function() {
			$(this).removeClass('ultimate-call-to-action-hover');
			var background = $(this).data('background');
			$(this).css({'background-color':background});
		});
		
		resize_call_to_action();
		
		$(window).resize(function(){
			resize_call_to_action();
		});
	});
	
	function resize_call_to_action()
	{
		$('.ultimate-call-to-action').each(function(i,element){
			var override = $(element).data('override');
			if(override != 0)
			{
				$(element).css({'margin-left' : 0 });
				var is_relative = 'true';
				if($(element).parents('.wpb_row').length > 0)
					var ancenstor = $(element).parents('.wpb_row');
				else if($(element).parents('.wpb_column').length > 0)
					var ancenstor = $(element).parents('.wpb_column');
				else
					var ancenstor = $(element).parent();
				
				var parent = ancenstor;
				if(override=='full'){
					ancenstor= $('body');
					is_relative = 'false';
				}
				if(override=='ex-full'){
					ancenstor= $('html');
					is_relative = 'false';
				}
				if( ! isNaN(override)){
					for(var i=1;i<=override;i++){
						if(ancenstor.prop('tagName')!='HTML'){
							ancenstor = ancenstor.parent();
						}else{
							break;
						}
					}
				}
				
				var w = ancenstor.outerWidth();
				
				var element_left = $(element).offset().left;
				var element_left_pos = $(element).position().left;
				var holder_left = ancenstor.offset().left;
				var holder_left_pos = ancenstor.position().left;
				var calculate_left = holder_left - element_left;
				
				if(override!='full' && override!='ex-full')
				{
					calculate_left = holder_left - holder_left_pos;
				}

				$(element).css({'width':w, 'margin-left' : calculate_left });
			}
		});
	}
}( jQuery ));