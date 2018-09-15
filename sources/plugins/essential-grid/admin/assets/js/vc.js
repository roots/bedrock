window.VcEssentialGrid = vc.shortcode_view.extend({
	render: function () {
		
		cur_vc_obj = this;
		var params = this.model.get('params');
		
		if(vc.add_element_block_view.$el.is(':visible')){ //hack to check if we just loaded the page or if we rendered it because of adding a new Ess. Grid element
			esg_vc_show_overlay(params);
		}
		return window.VcEssentialGrid.__super__.render.call(this);
	},
	editElement: function() {
		cur_vc_obj = this;
		var params = this.model.get('params');
		
		esg_vc_show_overlay(params);
		return false;
	}
});

if(typeof(window.InlineShortcodeView) !== 'undefined'){
	var show_frontend_overlay = false;
	
	jQuery(window).on('vc_build',function(){
		vc.add_element_block_view.$el.find('[data-element="ess_grid"]').click(function(){ show_frontend_overlay = true; });
	});
	
	window.InlineShortcodeView_ess_grid = window.InlineShortcodeView.extend({
		render: function() {
			
			cur_vc_obj = this;
			var params = this.model.get('params');
			
			if(show_frontend_overlay){
				esg_vc_show_overlay(params);
			}
			
			window.InlineShortcodeView_ess_grid.__super__.render.call(this);
			
			return this;
			
		},
		update: function() {
		
			show_frontend_overlay = false;
			
			// same function as backend changedShortcodeParams
			window.InlineShortcodeView_ess_grid.__super__.update.call(this);
			
			return this;
		},
		edit: function( e ) {
			cur_vc_obj = this;
			var params = this.model.get('params');
			
			esg_vc_show_overlay(params);
			
			return false;
		}
	});
}

function esg_vc_show_overlay(params){

	if ( cur_vc_obj !== false && cur_vc_obj.model.get('cloned') === true){
		//set cloned to false, so that the edit button will work. Then return as this is at the process where the element gets cloned
		cur_vc_obj.model.save('cloned', false);
		
		return; //do not show edit if we cloned
	}
	
	esg_tiny_reset_all();
	
	ess_grid_is_vc = true; //set for the saving that we are visual composer

	jQuery('.wpb-element-edit-modal').hide(); //hide the normal VC window and use own (old vc version)
	jQuery('#vc_properties-panel').hide(); //hide the normal VC window and use own (new vc version)
	
	var ess_grid_vc_variables = {};
	
	ess_grid_vc_variables['alias'] = (typeof(params.alias) !== 'undefined') ? params.alias : '';
	ess_grid_vc_variables['settings'] = (typeof(params.settings) !== 'undefined') ? params.settings.replace(/\'/g, '"') : '';
	ess_grid_vc_variables['layers'] = (typeof(params.layers) !== 'undefined') ? params.layers.replace(/\'/g, '"') : '';
	ess_grid_vc_variables['special'] = (typeof(params.special) !== 'undefined') ? params.special : '';
	
	jQuery('#ess-grid-tiny-dialog-step-1').show();
	jQuery('#ess-grid-tiny-dialog-step-2').hide();
	jQuery('#ess-grid-tiny-dialog-step-3').hide();
	
	jQuery('#ess-grid-tiny-mce-dialog').dialog({
		id       : 'ess-grid-tiny-mce-dialog',
		title	 : eg_lang.shortcode_generator,
		width    : 720,
		height   : 'auto'
	});
	
	if(ess_grid_vc_variables['special'] !== ''){ //special
		
		esg_create_by_predefined = ess_grid_vc_variables['special'];
		
		//special stuff here
		if(ess_grid_vc_variables['alias'] !== ''){
			jQuery('select[name="ess-grid-tiny-existing-settings"] option').each(function(){
				if(jQuery(this).val() == ess_grid_vc_variables['alias']) jQuery(this).attr('selected', true);
			});
			
			if(ess_grid_vc_variables['settings'] !== ''){
				var sett = jQuery.parseJSON(ess_grid_vc_variables['settings']);
				
				if(typeof(sett['max-entries']) !== 'undefined')
					jQuery('input[name="ess-grid-tiny-max-entries"]').val(sett['max-entries']);
			}
		}
		
		jQuery('#eg-goto-step-2').click();
		
	}else if(ess_grid_vc_variables['layers'] != '' && ess_grid_vc_variables['settings'] != '' || ess_grid_vc_variables['layers'] != '' && ess_grid_vc_variables['alias'] != ''){
		
		var ess_shortcode = '[ess_grid ';
		
		if(ess_grid_vc_variables['alias'] !== '')
			ess_shortcode += ' alias="'+ess_grid_vc_variables['alias']+'"';
			
		if(ess_grid_vc_variables['settings'] !== '')
			ess_shortcode += " settings='"+ess_grid_vc_variables['settings']+"'";
			
		if(ess_grid_vc_variables['layers'] !== '')
			ess_shortcode += " layers='"+ess_grid_vc_variables['layers']+"'";
			
		ess_shortcode += '][/ess_grid]';
		
		jQuery('input[name="eg-shortcode-analyzer"]').val(ess_shortcode);
		jQuery('#eg-shortcode-do-analyze').click();
		
	}else if(ess_grid_vc_variables['alias'] !== '' && ess_grid_vc_variables['special'] == ''){ //only grid with alias
		
		jQuery('select[name="ess-grid-existing-grid"] option').each(function(){
			if(jQuery(this).val() == ess_grid_vc_variables['alias']){
				jQuery(this).attr('selected', true);
			}
		});
		
	}else{ /*seems like a new grid  */ }
}