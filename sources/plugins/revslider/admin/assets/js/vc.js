window.VcSliderRevolution = vc.shortcode_view.extend({
	render: function () {
		rs_cur_vc_obj = this;
		var params = this.model.get('params');
		
		if(vc.add_element_block_view.$el.is(':visible')){ //hack to check if we just loaded the page or if we rendered it because of adding a new Slider element
			rs_vc_show_overlay(params);
		}
		return window.VcSliderRevolution.__super__.render.call(this);
	},
	editElement: function() {
		rs_cur_vc_obj = this;
		var params = this.model.get('params');
		
		rs_vc_show_overlay(params);
		return false;
	}
});

if(typeof(window.InlineShortcodeView) !== 'undefined'){
	var rs_show_frontend_overlay = false;
	
	jQuery(window).on('vc_build',function(){
		vc.add_element_block_view.$el.find('[data-element="rev_slider"]').click(function(){ rs_show_frontend_overlay = true; });
	});
	
	window.InlineShortcodeView_rev_slider = window.InlineShortcodeView.extend({
		render: function() {
			rs_cur_vc_obj = this;
			var params = this.model.get('params');
			
			if(rs_show_frontend_overlay){
				rs_vc_show_overlay(params);
			}
			
			window.InlineShortcodeView_rev_slider.__super__.render.call(this);
			
			return this;
			
		},
		update: function(model) {
			
			rs_show_frontend_overlay = false;
			
			// same function as backend changedShortcodeParams
			window.InlineShortcodeView_rev_slider.__super__.update.call(this,model);
			
			return this;
		},
		edit: function( e ) {
			
			rs_cur_vc_obj = this;
			var params = this.model.get('params');
			
			rs_vc_show_overlay(params);
			
			return false;
		}
	});
}

function rs_vc_show_overlay(params){
	
	if ( rs_cur_vc_obj !== false && rs_cur_vc_obj.model.get('cloned') === true){
		//set cloned to false, so that the edit button will work. Then return as this is at the process where the element gets cloned
		rs_cur_vc_obj.model.save('cloned', false);
		
		return; //do not show edit if we cloned
	}
	
	revslider_tiny_reset_all();
	
	revslider_is_vc = true; //set for the saving that we are visual composer

	jQuery('.wpb-element-edit-modal').hide(); //hide the normal VC window and use own (old vc version)
	jQuery('#vc_properties-panel').hide(); //hide the normal VC window and use own (new vc version)
	
	var revslider_vc_variables = {};
	
	revslider_vc_variables['alias'] = (typeof(params.alias) !== 'undefined') ? params.alias : '';
	revslider_vc_variables['order'] = (typeof(params.order) !== 'undefined') ? params.order : ''; //.replace(/\'/g, '"')
	
	jQuery('#revslider-tiny-dialog-step-1').show();
	jQuery('#revslider-tiny-dialog-step-1-5').hide();
	
	jQuery('#revslider-tiny-mce-dialog').dialog({
		id       : 'revslider-tiny-mce-dialog',
		width    : 900,
		height   : 600,
		resizable: false
	});
	
	if(revslider_vc_variables['alias'] !== ''){ //only slider with alias
		jQuery('select[name="revslider-existing-slider"] option').each(function(){
			if(jQuery(this).val() == revslider_vc_variables['alias']){
				jQuery(this).attr('selected', true);
				var slid = jQuery(this).data('sliderid');
				jQuery('#slider_list_item_'+slid).addClass('selected');
				jQuery('#revslider-existing-slider option:selected').change();
			}
		});
		
		if(revslider_vc_variables['order'] != ''){
			jQuery('#revslider-tiny-dialog-step-1').hide();
			jQuery('#revslider-tiny-dialog-step-1-5').show();
			
			
			var rs_raw_construct = wp.template( "rs-modify-slide-wrap" );
			var sel = jQuery('#revslider-existing-slider option:selected');
			jQuery('.rs-mod-slides-wrapper').html(''); //reset HTML
			
			//check if array or string
			if(!Array.isArray(revslider_vc_variables['order'])){
				revslider_vc_variables['order'] = revslider_vc_variables['order'].split(',');
			}
			
			if(typeof(rev_sliders_info) !== 'undefined'){
				for(var key in rev_sliders_info){
					if(key == sel.data('sliderid')){
						var my_entry = new Object();
						
						my_entry = jQuery.extend(true,{},my_entry, rev_sliders_info[key]);																		
						var my_entries = [];
						var act_slide = -1;
						
						for(var okey in revslider_vc_variables['order']){
							for(var sl in my_entry){
								if(my_entry[sl]['slider_type'] == 'hero'){
									if(revslider_vc_variables['order'][okey] == my_entry[sl]['id']){
										act_slide = my_entry[sl]['id'];
									}
								}else{
									break;
								}
							}
						}
						
						for(var okey in revslider_vc_variables['order']){
							for(var sl in my_entry){ //add all found slides, empty the old ones first
								if(my_entry[sl]['slider_type'] == 'hero'){
									my_entry[sl]['active_slide'] = act_slide;
								}
								if(revslider_vc_variables['order'][okey] == my_entry[sl]['id']){
									my_entry[sl]['mstate'] = 'published';
									my_entry[sl]['state'] = 'published';
									
									my_entries.push(my_entry[sl]);
						
									break;
								}
							}
							
						}
						
						for(var slm in my_entry){
							if(my_entry[slm]['mstate'] == undefined){
								my_entry[slm]['state'] = 'unpublished';
								if(my_entry[slm]['slider_type'] == 'hero'){
									my_entry[sl]['active_slide'] = act_slide;
								}
								my_entries.push(my_entry[slm]);
							}
						}
						for(var ekey in my_entries){
							var content = rs_raw_construct(my_entries[ekey]);
							
							jQuery('.rs-mod-slides-wrapper').append(content);
						}
					}
				}
			}
		}
	}else{  }
}