jQuery(document).ready(function(){
	var inline_form 	= jQuery(".edit_form_line");
	var shortcode 		= jQuery("#shortcode");
	var display_type 	= jQuery("#display_type"),
		per_page 		= jQuery("#per_page"),
		columns 		= jQuery("#columns"),
		orderby 		= jQuery("#orderby"),
		order 			= jQuery("#order"),
		cat 			= jQuery("#cat");
		cat_lbl 		= jQuery("#cat").prev("label");
		cat_div 		= jQuery(".cat");
	var obj = [display_type, per_page, columns, orderby, order, cat, cat_lbl, cat_div];
	jQuery.each(obj,function(index,item){
		item.bind("change",function(){
			generateShortcode();
		});
	});
	if(display_type.val() != "product_category" && display_type.val() != "product_categories"){
		cat.hide();
		cat_lbl.hide();
		cat_div.hide();
		cat.addClass("none");
	}
	if(display_type.val() == "product_categories"){
		cat.attr("multiple","true");
		cat.addClass("multiple");
	} else {
		cat.removeAttr("multiple");
		cat.removeClass("multiple");
	}
	if(jQuery("#shortcode").val() == ""){
		generateShortcode();
	}
	display_type.bind("change",function(){
		if(jQuery(this).val() == "product_category"  || jQuery(this).val() == "product_categories"){
			cat.show();
			cat.removeClass("none");
			cat_lbl.show();
			cat_div.show();
		} else {
			cat.hide();
			cat.addClass("none");
			cat_lbl.hide();
			cat_div.hide();
		};
		if(jQuery(this).val() == "product_categories"){
			cat.attr("multiple","true");
			cat.addClass("multiple");
			cat.select2({
				placeholder: "Select a Category",
				allowClear: true,
			});
			cat_lbl.show();
			cat_div.show();
		} else if(jQuery(this).val() == "product_category"){ 
			cat.removeAttr("multiple");
			cat.removeClass("multiple");
			cat.select2({
				placeholder: "Select a Category",
				allowClear: true
			});
			cat_lbl.show();
			cat_div.show();
		} else {
			cat_lbl.hide();
			cat_div.hide();
		}
	});
	inline_form.click(function(){
		generateShortcode();
	});
});
function generateShortcode(){
	var inline_form 	= jQuery(".edit_form_line");
	var shortcode 		= jQuery("#shortcode");
	var display_type 	= jQuery("#display_type"),
		per_page 		= jQuery("#per_page"),
		columns 		= jQuery("#columns"),
		orderby 		= jQuery("#orderby"),
		order 			= jQuery("#order"),
		cat 			= jQuery("#cat");
		cat_lbl 		= jQuery("#cat").prev("label");
		cat_div 		= jQuery(".cat"),
		data 			= "[";
	if(!display_type.hasClass("none")){
		data += display_type.val()+" ";
	}
	if(!per_page.hasClass("none")){
		if(display_type.val() == "product_categories"){
			data += ' number="'+per_page.val()+'"';
		} else {
			data += ' per_page="'+per_page.val()+'"';
		}
	}
//if($module == "grid"){
	if(!columns.hasClass("none")){
		data += ' columns="'+columns.val()+'"';
	}
//}
	if(!orderby.hasClass("none")){
		data += ' orderby="'+orderby.val()+'"';
	}
	if(!order.hasClass("none")){
		data += ' order="'+order.val()+'"';
	}
	if(!cat.hasClass("none")){
		if(display_type.val() == "product_categories"){
			data += ' ids="'+cat.val()+'"';
		} else {
			data += ' category="'+cat.children("option:selected").text().toLowerCase()+'"';
		}
	}
	data += "]";
	shortcode.val(base64_encode(rawurlencode(data)));
	//shortcode.val(data);
}