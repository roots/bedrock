<?php
if (! class_exists ( 'ESSBLiveCustomizerControls' )) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}

$mobile_columns = array ("1" => "1 Button", "2" => "2 Buttons", "3" => "3 Buttons", "4" => "4 Buttons", "5" => "5 Buttons", "6" => "6 Buttons" );

$mobile_sharebar_text = essb_option_value ( 'mobile_sharebar_text' );
$mobile_sharebuttonsbar_count = essb_option_value ( 'mobile_sharebuttonsbar_count' );
$mobile_sharebuttonsbar_total = essb_option_value ( 'mobile_sharebuttonsbar_total' );
$mobile_css_activate = essb_option_value('mobile_css_activate');

$mobile_positions = essb_option_value ( 'mobile_positions' );
$button_positions_mobile = essb_option_value ( 'button_position_mobile' );
$button_position_mobile = '';

if (is_array($button_positions_mobile)) {
	foreach ($button_positions_mobile as $position) {
		if ($position == 'sharebottom' || $position == 'sharebar' || $position == 'sharepoint' && $button_position_mobile == '') {
			$button_position_mobile = $position;
		}
	}
}

$essb_available_button_positions_mobile = array ();
$essb_available_button_positions_mobile ['sharebottom'] = array ("image" => "assets/images/display-positions-17.png", "label" => "Buttons" );
$essb_available_button_positions_mobile ['sharebar'] = array ("image" => "assets/images/display-positions-18.png", "label" => "Bar" );
$essb_available_button_positions_mobile ['sharepoint'] = array ("image" => "assets/images/display-positions-19.png", "label" => "Point" );

global $essb_networks;
$checkbox_list_networks = array ();
$mobile_networks_order = essb_option_value('mobile_networks_order');
if (is_array($mobile_networks_order)) {
	if (has_filter('essb4_social_networks_update_list')) {
		$mobile_networks_order = apply_filters('essb4_social_networks_update_list', $mobile_networks_order);
	}
	
	foreach ($mobile_networks_order as $text_value) {
		$keys = explode('|', $text_value);
			
		$key = $keys[0];
		$text = $keys[1];
			
		$checkbox_list_networks[$key] = $text;
	}
}
else {
	foreach ( $essb_networks as $key => $object ) {
		
		if ($key == 'more' || $key == 'share' || $key == 'comments') {
			continue;
		}
		
		$checkbox_list_networks [$key] = $object ['name'];
	}
}
$mobile_networks = essb_option_value ( 'mobile_networks' );

if (! is_array ( $mobile_networks )) {
	$mobile_networks = essb_option_value ( 'networks' );
}

$mobile_template = essb_option_value('mobile_template');
$mobile_custom_update_template = '';
if ($button_position_mobile != '') {
	$mobile_template = essb_option_value($button_position_mobile.'_template');
	$mobile_custom_update_template = $button_position_mobile.'_template';
}

?>
<!-- avoid display of content share buttons on mobile devices -->
<input type="hidden" class="section-save" data-update="options"
	data-field="content_position_mobile" value="shortcode" />

<input type="hidden" class="section-save" data-update="options"
	data-field="mobile_css_readblock" value="true" />
<input type="hidden" class="section-save" data-update="options"
	data-field="mobile_css_all" value="true" />
<input type="hidden" class="section-save" data-update="options"
	data-field="mobile_css_optimized" value="true" />
	
<div class="section-mobile">
	<div class="row field">Use Optimized Mobile Display</div>
	<div class="row param">
		<?php
		ESSBLiveCustomizerControls::draw_switch_field2 ( 'mobile_positions', $mobile_positions, 'options', 'mobile_positions' );
		?>
	</div>
	<div class="row description">Setup personalized display of social share
		buttons on mobile devices use mobile optimized display methods.</div>

	<div class="mobile-active" <?php if ($mobile_positions != 'true') { echo ' style="display: none;"'; }?>>
		<div class="row field">Mobile Position of Share Buttons</div>
		<div class="row description">Select the best for your site position of
			mobile share buttons (most popular: Buttons)</div>
		<div class="row param">
		<?php
		ESSBLiveCustomizerControls::draw_image_radio_field ( 'button_position_mobile', 'options', $button_position_mobile, $essb_available_button_positions_mobile );
		?>
		</div>


		<div class="mobile-buttonsbar subsection" <?php if ($button_position_mobile != 'sharebottom') { echo ' style="display: none;"'; }?>>
			<div class="row">
				<div class="col1-2">
					<div class="row field">Number of visible buttons</div>
					<div class="row description">Choose how may buttons will be visible
						on site. If the count of networks you select is greater than
						buttons count plugin will include more open button.</div>
					<div class="row param">
					<?php
					ESSBLiveCustomizerControls::draw_select_field ( 'mobile_sharebuttonsbar_count', 'options', $mobile_sharebuttonsbar_count, $mobile_columns );
					?>
				</div>
				</div>
				<div class="col1-2">
					<div class="row field">Show Total Counter</div>
					<div class="row description">Use this to show total counter as a first button in your buttons list.</div>
					<div class="row param">
				<?php
				ESSBLiveCustomizerControls::draw_switch_field2 ( 'mobile_sharebuttonsbar_total', $mobile_sharebuttonsbar_total, 'options', 'mobile_sharebuttonsbar_total' );
				?>
				</div>
				</div>
			</div>
		</div>

		<div class="mobile-bar subsection" <?php if ($button_position_mobile != 'sharebar') { echo ' style="display: none;"'; }?>>
			<div class="row field">Share Bar Text</div>
			<div class="row param">
				<input name="mobile_sharebar_text" type="text" class="section-save"
					data-update="options" data-field="mobile_sharebar_text" rows="4"
					placeholder="Example: Share This Article"
					value="<?php echo $mobile_sharebar_text; ?>" />
			</div>
			<div class="row description">Customize the default text of the bar</div>
		</div>
		<div class="row field">Social networks</div>
		<div class="row description">Choose which networks will appear on
			mobile devices</div>
		<div class="row param">
		<?php
		ESSBLiveCustomizerControls::draw_checkbox_list_sortable_field ( 'mobile_networks', $checkbox_list_networks, 'options', $mobile_networks, true );
		?>
		</div>
		
		
	<div class="row field">Use Reponsive Mode Instead Of Mobile Device Detection</div>
	<div class="row param">
		<?php
		ESSBLiveCustomizerControls::draw_switch_field2 ( 'mobile_css_activate', $mobile_css_activate, 'options', 'mobile_css_activate' );
		?>
	</div>
	<div class="row description">Use this option if you have cache plugin that does not support mobile caching. Once you activate it plugin will use old responsive method to show mobile settings. We highly recommend if possible configre your cache plugin to allow mobile caching because mobile detection will delivered better optimized and visual enchanced for mobile displays.</div>
		
	</div>
	<div class="row">
		<a href="#"
			class="essb-composer-button essb-composer-blue essb-section-save"
			data-section="section-mobile"><i class="fa fa-save"></i> Save Settings</a>
	</div>

</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {
	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');

	    if (jQuery(this).hasClass('mobile_positions')) {
		    if (jQuery(this).hasClass('checked'))
		    	jQuery('.mobile-active').fadeIn();
		    else
		    	jQuery('.mobile-active').fadeOut();
	    }
	  });

	
	jQuery(".essb-switch.mobile_positions .cb-enable").click(function(){
		jQuery('.mobile-active').fadeIn();
	});

	jQuery(".essb-switch.mobile_positions .cb-disable").click(function(){
		jQuery('.mobile-active').fadeOut();
	});

	jQuery(".essb_image_radio").click(function() {
		var radio_element = jQuery(this).find('input[type="radio"]');
		if (jQuery(radio_element).is(':checked')) {
			var selected = jQuery(radio_element).val();
			jQuery(".mobile-bar").hide();
			jQuery(".mobile-buttonsbar").hide();
			if (selected == "sharebottom") {
				jQuery(".mobile-buttonsbar").fadeIn();
			}
			if (selected == "sharebar") {
				jQuery(".mobile-bar").fadeIn();
			}

			//if (jQuery('#mobile_template').length)
			//	jQuery('#mobile_template').attr('data-field', selected + '_template');
}
	});

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