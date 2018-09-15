!function($) {
	$(document).ready(function(){
		$('.wpb_el_type_ultimate_hotspot_param').each(function(i,p){
			var hlink = ULT_H_img_link;
			$img = $(p).find('.ult-hotspot-image');
			$img.attr('src', hlink);
			if(ULT_H_Size == 'main_img_custom')
			{
				$img.css({'width':ULT_H_custom_size+'px'});
			}
		});	
		if(typeof $.fn.draggable !== 'undefined') {
			$(".ult-hotspot-draggable").draggable({
				containment: "parent",
				create: function( event, ui ) {
					var current_position = $(this).next('.ult-hotspot-positions').val();
					var positions = current_position.split(",");
					$(this).css({'top':positions[0]+'%'});
					if(typeof positions[1] != 'undefined')
						$(this).css({'left':positions[1]+'%'});
				},
				stop: function( event, ui ) {
					var current_position = '';
					var $img = $(this).prev('.ult-hotspot-image');
					var img_width = $img.width();
					var img_height = $img.height();
					var top = (ui.position.top/img_height)*100;
					var left = (ui.position.left/img_width)*100;
					current_position = top+','+left;
					$(this).next('.ult-hotspot-positions').val(current_position);
				}
			});
		}
	});
}(jQuery)