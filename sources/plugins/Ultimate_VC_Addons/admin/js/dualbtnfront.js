jQuery(document).ready(function() {
//alert('hi');

//console.log(this.model.get("params"));
	/*jQuery("body").on("click",".vc_control-btn-edit",function(){
		
		//var element = jQuery(this).parents('.vc_element:first');
		//var model_id = jQuery(element).data('model-id');
		//console(model_id);
	});*/



    jQuery("body").on("click",".vc_panel-btn-save",function(){
    	
    	var data = jQuery(this).parent().parent();
    		
	  var dp=data.find(".wpb_edit_form_elements").data('title');//console.log(dp);
		if(dp=='Edit Dual Button'){
			jQuery(".ult_main_dualbtn").each(function() {
				console.log('1');
			var t=jQuery(".ult_dual1").css({"height","100px"});
			//console.log(t);
		});
		}

	});
});
