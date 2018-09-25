/*
 * ---------------------------------------------------------------- 
 *  Renown Core JavaScript
 * ----------------------------------------------------------------  
 */

jQuery(document).ready(function($){	 	
  	
  	var icons_holder = $('.wpb_el_type_checkbox');
  	
  	if($('.wpb_edit_form_elements').data('title') == 'Edit Icon Box' || $('.wpb_edit_form_elements').data('title') == 'Edit Button') {  		
  	
	  	var icons = icons_holder.find('input');
	  	
	  	icons_holder.addClass('icon-checkboxes');
	  	icons_holder.find('.edit_form_line').contents().filter(function(){ return this.nodeType != 1; }).remove();
		
		var i = 0;
		icons.each(function() {
			if(i==0) {
				$(this).remove();
			} else {
				$(this).after('<label for="'+$(this).attr('id')+'" class="fa '+$(this).val()+'"></label>');		
			}
			i++;
		});
		
		$('.wpb_el_type_init_icons').hide();
		
		$(icons).click(function(){
		    $(icons).attr("checked",false);
		    $(this).attr("checked",true);
		});
	
	} 
	
});