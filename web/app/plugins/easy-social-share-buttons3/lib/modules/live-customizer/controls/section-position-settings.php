<?php

if (! class_exists ( 'ESSBLiveCustomizerControls' )) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}

function essb_translate_key_array($array) {
	if (!is_array($array)) {
		return array();
	}

	$key_array = array();

	foreach ($array as $text_value) {
		$keys = explode('|', $text_value);
			
		$key = $keys[0];
		$text = $keys[1];
			
		$key_array[$key] = $text;
	}

	return $key_array;
}

$animations_container = array ();
$animations_container[""] = "Default value from settings";
foreach (essb_available_animations() as $key => $text) {
	if ($key != '') {
		$animations_container[$key] = $text;
	}
	else {
		$animations_container['no'] = 'No amination';
	}
}

$position = isset($_REQUEST['position']) ? $_REQUEST['position'] : '';
$position_title = $position;

$buttons_width = essb_option_value($position.'_button_width');

foreach ( essb_avaliable_content_positions () as $key => $data ) {
	if ($key == $position) {
		$position_title = $data ['label'];	
	}
}

foreach ( essb_available_button_positions () as $key => $data ) {
	if ($key == $position) {
		$position_title = $data ['label'];	
	}
}

// generate networks used for this position
global $essb_networks;
$checkbox_list_networks = array ();
$position_networks_order = essb_option_value($position.'_networks_order');
if (is_array($position_networks_order)) {
	
	if (has_filter('essb4_social_networks_update_list')) {
		$position_networks_order = apply_filters('essb4_social_networks_update_list', $position_networks_order);
	}

	foreach ($position_networks_order as $text_value) {
		$keys = explode('|', $text_value);
			
		$key = $keys[0];
		$text = $keys[1];
		
		$checkbox_list_networks[$key] = $text;
	}
}
else {
	foreach ( $essb_networks as $key => $object ) {
		$checkbox_list_networks [$key] = $object ['name'];
	}
}
$position_networks = essb_option_value ( $position.'_networks' );


//essb-open-location
$location_key = '';
if ($position == 'top') {
	$location_key = 'display-4';
}
if ($position == 'bottom') {
	$location_key = 'display-5';
}
if ($position == 'float') {
	$location_key = 'display-6';
}
if ($position == 'postfloat') {
	$location_key = 'display-7';
}
if ($position == 'sidebar') {
	$location_key = 'display-8';
}
if ($position == 'topbar') {
	$location_key = 'display-9';
}
if ($position == 'bottombar') {
	$location_key = 'display-10';
}
if ($position == 'popup') {
	$location_key = 'display-11';
}
if ($position == 'flyin') {
	$location_key = 'display-12';
}
if ($position == 'heroshare') {
	$location_key = 'display-14';
}
if ($position == 'postbar') {
	$location_key = 'display-15';
}
if ($position == 'point') {
	$location_key = 'display-16';
}

$location_url = admin_url('admin.php?page=essb_redirect_where&tab=where&section=display&subsection=' . $location_key);



?>

<div class="section-position-settings">
	<input type="hidden" id="position" class="section-save" name="position" data-field="position" data-update="options" value="<?php echo $position; ?>"/>
	<input type="hidden" id="<?php echo $position; ?>_activate" class="section-save" name="<?php echo $position?>_activate" data-field="<?php echo $position?>_activate" data-update="options" value="true"/>
	<div class="customizer-inner-title"><span><?php echo $position_title; ?></span></div>

	<div class="row field">Social networks</div>
	<div class="row description">Choose custom network list only if you wish to save such for that location. Leave all fields blank if you wish to use the default selected network list from global settings. <b>Drag & drop network order will not reflect automatically in real time preview. The change will appear on screen once another option is changed or when you press Update Preview button.</b></div>
	<div class="row param">
		<?php
		ESSBLiveCustomizerControls::draw_checkbox_list_sortable_field ( $position.'_networks', $checkbox_list_networks, 'options', $position_networks, true );
		?>
	</div>
	
	<div class="row">
		<div class="col1-3 subsection">
		<div class="row field">Button Style</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_button_style', 'options', essb_option_value($position.'_button_style'), essb_avaiable_button_style());
		?>
		</div>

		<div class="row field">Button Align</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_button_pos', 'options', essb_option_value($position.'_button_pos'),  array("" => "Left", "center" => "Center", "right" => "Right"));
		?>
		</div>

		<div class="row field">Template</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_template', 'options', essb_option_value($position.'_template'), essb_available_tempaltes4(true));
		?>
		</div>
		
		
		</div>
		<div class="col1-3 subsection white">
		
		<div class="row field">Display Counters</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2($position.'_show_counter', essb_option_value($position.'_show_counter'), 'options', $position.'_show_counter');
		?>
		</div>
		
		<div class="row field">Position of counter in button</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_counter_pos', 'options', essb_option_value($position.'_counter_pos'), essb_avaliable_counter_positions());
		?>
		</div>

		<div class="row field">Position of total counter</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_total_counter_pos', 'options', essb_option_value($position.'_total_counter_pos'), essb_avaiable_total_counter_position());
		?>
		</div>
		
		</div>
		<div class="col1-3 subsection">
		
		<div class="row field">Width of Share Buttons</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_button_width', 'options', essb_option_value($position.'_button_width'), array(''=>'Automatic Width', 'fixed' => 'Fixed Width', 'full' => 'Full Width', "column" => "Display in columns", "flex" => "Flex width"));
		?>
		</div>
		
		<div class="width-concept fixed_button_width" <?php if ($buttons_width == 'fixed') { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; }?>>
			<div class="row">
			<div class="subsection white">
				<div class="col1-2">
					<div class="row field">Width of Button</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_textbox_field($position.'_fixed_width_value', 'options', essb_option_value($position.'_fixed_width_value'), 'Example: 60');
					?>
					</div>
				</div>
				
				<div class="col1-2">
					<div class="row field">Network Text Align</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_select_field($position.'_fixed_width_align', 'options', essb_option_value($position.'_fixed_width_align'), array("" => "Center", "left" => "Left", "right" => "Right"));
					?>
					</div>
				</div>
			</div>
			</div>
		</div>
		
		<div class="width-concept full_button_width" <?php if ($buttons_width == 'full') { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; }?>>
			<div class="row">
			<div class="subsection white">
				<div class="col1-2">
					<div class="row field">Width of Button</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_textbox_field($position.'_fullwidth_share_buttons_correction', 'options', essb_option_value($position.'_fullwidth_share_buttons_correction'), 'Example: 80');
					?>
					</div>
				</div>
				
				<div class="col1-2">
					<div class="row field">Network Text Align</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_select_field($position.'_fullwidth_align', 'options', essb_option_value($position.'_fullwidth_align'), array("" => "Left", "center" => "Center", "right" => "Right"));
					?>
					</div>
				</div>
			</div>
			</div>
		</div>
		
		<div class="width-concept column_button_width" <?php if ($buttons_width == 'column') { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; }?>>
			<div class="row">
			<div class="subsection white">
				<div class="col1-2">
					<div class="row field">Number of Columns</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_select_field($position.'_fullwidth_share_buttons_columns', 'options', essb_option_value($position.'_fullwidth_share_buttons_columns'), array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5"));
					?>
					</div>
				</div>
				
				<div class="col1-2">
					<div class="row field">Network Text Align</div>
					<div class="row param">
					<?php 
					ESSBLiveCustomizerControls::draw_select_field($position.'_fullwidth_share_buttons_columns_align', 'options', essb_option_value($position.'_fullwidth_share_buttons_columns_align'), array("" => "Left", "center" => "Center", "right" => "Right"));
					?>
					</div>
				</div>
			</div>
			</div>
			
			
		</div>
		
				<div class="row field">Remove Space Between Buttons</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2($position.'_nospace', essb_option_value($position.'_nospace'), 'options', $position.'_nospace');
		?>
		</div>
		
		<div class="row field">Animation</div>
		<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field($position.'_css_animations', 'options', essb_option_value($position.'_css_animations'), $animations_container);
		?>
		</div>
		
		
		</div>

	</div>
	
	<!-- end row: settings -->
	<!-- begin: live preview -->
	<div class="row">
		<div class="customizer-inner-title"><span>Live Preview</span></div>
		<div class="essb-customizer-preview">
		
		<?php 
		
		echo essb_core()->generate_share_buttons($position, 'share', array("only_share" => true));
		
		?>
		
		</div>
	</div>
</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {
	var position = jQuery('#position').val();
	var buttonWidth = jQuery("#"+position+"_button_width").val();

	jQuery("#"+position+"_button_width").change(function() {
		jQuery('.width-concept').hide();

		var buttonWidth = jQuery(this).val();

		if (jQuery('.'+buttonWidth+'_button_width').length)
			jQuery('.'+buttonWidth+'_button_width').fadeIn();
	});
	
	jQuery( ".section-position-settings .section-save" ).change(function() {
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	});

	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	  });

	jQuery(".section-position-settings .essb-switch.<?php echo $position; ?>_nospace .cb-enable").click(function(){
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	});

	jQuery(".section-position-settings .essb-switch.<?php echo $position; ?>_nospace .cb-disable").click(function(){
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	});

	jQuery(".section-position-settings .essb-switch.<?php echo $position; ?>_show_counter .cb-enable").click(function(){
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	});

	jQuery(".section-position-settings .essb-switch.<?php echo $position; ?>_show_counter .cb-disable").click(function(){
		var options = essbLiveCustomizer.generateSectionOptions('section-position-settings');
		
		essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);
	});

	if (jQuery('.essb-open-location').length) {
		jQuery('.essb-open-location').attr('href', '<?php echo $location_url; ?>');
	}
	//$location_url

	var debounce = function( func, wait ) {
		var timeout, args, context, timestamp;
		return function() {
			context = this;
			args = [].slice.call( arguments, 0 );
			timestamp = new Date();
			var later = function() {
				var last = ( new Date() ) - timestamp;
				if ( last < wait ) {
					timeout = setTimeout( later, wait - last );
				} else {
					timeout = null;
					func.apply( context, args );
				}
			};
			if ( ! timeout ) {
				timeout = setTimeout( later, wait );
			}
		};
	};
	
	function quickFilterDebounceRun () {
		var value = jQuery(this).val();
		value = value.toLowerCase();
		
		var filterContainer = jQuery(this).attr('data-filter') || '';
		if (filterContainer == '') return;
		
		var element = jQuery('#'+filterContainer);
		if (!element.length) return;
		
		jQuery(element).find("li").each(function(){
		    if (value == '') {
		    	jQuery(this).removeClass('filter-yes');
		    	jQuery(this).removeClass('filter-no');
		    } 
		    else {
		    	var singleValue = (jQuery(this).attr('data-filter-value') || '').toLowerCase();
		    	jQuery(this).removeClass('filter-yes');
		    	jQuery(this).removeClass('filter-no');
		    	if (singleValue.indexOf(value) > -1) 
		    		jQuery(this).addClass('filter-yes');
		    	else
		    		jQuery(this).addClass('filter-no');
		    }
		});
	}
	
	jQuery(".input-filter").keyup(debounce(quickFilterDebounceRun, 300));
}
		
</script>