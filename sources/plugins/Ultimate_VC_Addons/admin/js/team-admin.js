jQuery(document).ready(function(){

	function autoChange() {
		jQuery('.wpb_el_type_icon_manager').each(function(i,val){
			var sel = jQuery(this).find('.wpb_txt_icons_block'),
				current_i = (i+1),
				Icon_value = sel.data('old-icon-value'),
				Icon_values = '';

			sel.data('old-icon-value', current_i );
			Icon_values = sel.html();
			Icon_values = Icon_values.replace(Icon_value, current_i);
			
			sel.html(Icon_values);
			sel.find('li').each(function(){
				jQuery(this).attr('id', current_i);
			})
		});
	}

	vc.events.on('vc-param-group-add-new',function(){

		autoChange();

		jQuery('.wpb_txt_icon_value').each(function(i,val){
			jQuery(this).attr('id', i+1);
			
			var pcmd = jQuery(this).attr('id');
			var pmid = pcmd;

			var val=jQuery("#"+pcmd).val();
			if(val==""){
				val="none";	
			}
			if(val=="icon_color="){
				val="none";	
			}
			
			jQuery(".preview-icon-"+ pcmd ).html("<i class="+val+"></i>");
			
			jQuery(".icon-list-"+ pcmd +" li[data-icons="+ val+"]").addClass("selected");

			jQuery(".icons-list li").click(function() {
				
				var id=jQuery(this).attr("id");
	            jQuery(this).attr("class","selected").siblings().removeAttr("class");
	            var icon = jQuery(this).attr("data-icons");
	           
	            jQuery("#"+id).val(icon);
	            jQuery(".preview-icon-"+id).html("<i class="+icon+"></i>");
	            
            });
		});
	})
});