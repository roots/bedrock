<?php
if (! class_exists ( 'ESSBLiveCustomizerControls' )) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}

$content_position = essb_option_value ( 'content_position' );
$button_position = essb_option_value ( 'button_position' );

$list_of_content_positions = array ();
foreach ( essb_avaliable_content_positions () as $key => $data ) {
	$list_of_content_positions [$key] = $data ['label'];
}

$list_of_button_positions = array ();
foreach ( essb_available_button_positions () as $key => $data ) {
	$list_of_button_positions [$key] = $data ['label'];
}

?>

<div class="section-positions">
	<div class="customizer-inner-title">
		<span>Inside Content</span>
	</div>

	<div class="row field">Choose where buttons will appear inside content
		of each post type that is active</div>
	<div class="row param">
		<div class="col4-5">
		<?php
		ESSBLiveCustomizerControls::draw_select_field ( 'content_position', 'options', $content_position, $list_of_content_positions );
		?>
		</div>
		<div class="col1-5">
			<a href="#"
				class="essb-composer-button essb-composer-blue essb-composer-settings"
				title="Personalize share buttons style on this position" data-position-element="content_position"><i class="ti-ruler-pencil"></i></a>
		</div>
	</div>
	<div class="row description">
		In case you do not need share buttons inside content please choose
		from the drop down <b>Manual display with shortcode only</b>. From
		plugin settings you can also set different positions based on post
		types.
	</div>

	<div class="customizer-inner-title">
		<span>On Site Display</span>
	</div>
	<div class="row description">Choose additional display methods that can
		be used to display buttons.</div>

	<div class="row param">
	<?php
	
	foreach ( $list_of_button_positions as $key => $label ) {
		
		$icon = 'ti-layout';
		if ($key == 'sidebar') {
			$icon = 'ti-layout-sidebar-left';
		}
		if ($key == 'popup') {
			$icon = 'ti-layers';
		}
		if ($key == 'flyin') {
			$icon = 'ti-layout-media-right-alt';
		}
		if ($key == 'postfloat') {
			$icon = 'ti-layout-tab-v';
		}
		if ($key == 'topbar') {
			$icon = 'ti-layout-tab-window';
		}
		if ($key == 'bottombar') {
			$icon  = 'ti-layout-media-overlay';
		}
		if ($key == 'onmedia') {
			$icon = 'ti-image';
		}
		if ($key == 'postbar') {
			$icon = 'ti-layout-media-overlay-alt';
		}
		if ($key == 'widget') {
			$icon = 'ti-widget';
			$label = 'Widgets for Sharing & Popular Posts';
		} 
		
		echo '<div class="button-position">';
		echo '<div class="col4-5">';
		echo '<div class="title">';
		echo '<i class="'.$icon.'"></i>';
		echo '<span>' . $label . '</span>';
		echo '</div>';
		//echo '<div class="state">';
		//echo '<input type="checkbox" class="section-save" id="button-position-'.$key.'" value="' . $key . '" ' . (in_array ( $key, $button_position ) ? ' checked="checked"' : '') . ' data-field="button_position" data-update="options" data-format="array"/>';
		//echo '<label for="button-position-'.$key.'">Use on site</label>';
		//echo '</div>';
		echo '<div class="state">';
		echo '<label class="switch ' . (in_array ( $key, $button_position ) ? ' checked' : '') . '">
  <i class="icon-ok ti-check"></i>
  <i class="icon-remove ti-close"></i>
  <input type="checkbox" class="section-save" id="button-position-'.$key.'" value="' . $key . '" ' . (in_array ( $key, $button_position ) ? ' checked="checked"' : '') . ' data-field="button_position" data-update="options" data-format="array"/>
		</label>';
		echo '</div>';
		echo '</div>';
		echo '<div class="col1-5">';
		
		if ($key != 'widget' && $key != 'onmedia') {
			echo '<a href="#"
					class="essb-composer-button essb-composer-blue essb-composer-settings"
					title="Personalize share buttons style on this position" data-position="'.$key.'"><i class="ti-ruler-pencil"></i></a>';
		}
		else if ($key == 'onmedia') {
			//admin.php?page=essb_redirect_where&tab=where&section=display&subsection=display-13	
			echo '<a href="'.admin_url('admin.php?page=essb_redirect_where&tab=where&section=display&subsection=display-13').'"
			class="essb-composer-button essb-composer-blue essb-composer-settings1"
			title="Personalize share buttons style on this position" target="_blank" data-position="'.$key.'"><i class="ti-ruler-pencil"></i></a>';
		}

		echo '</div>';
		echo '</div>';
		
		
	}
	
	?>
	</div>
	
	<div class="customizer-inner-title">
		<span>Post Types</span>
	</div>
	<div class="row description">Choose post types where share buttons will automatically appear.</div>

	<div class="row param">
	<?php
	
	
	global $wp_post_types;
	$current_posttypes = essb_option_value('display_in_types');
	if (!is_array($current_posttypes)) {
		$current_posttypes = array();
	}
	
	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );
	
	echo '<ul class="post-type-select">';
	
	foreach ($pts as $pt) {
		$selected = in_array ( $pt, $current_posttypes ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" class="section-save" id="%1$s" value="%1$s" %2$s data-field="display_in_types" data-update="options" data-format="array"> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}
	
	foreach ($cpts as $pt) {
		$selected = in_array ( $pt, $current_posttypes  ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" class="section-save" id="%1$s" value="%1$s" %2$s data-field="display_in_types" data-update="options" data-format="array"> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}
	
	
	echo '</ul>';
	?>
	
		<div class="row">
		<a href="#"
			class="essb-composer-button essb-composer-blue essb-section-save"
			data-section="section-positions"><i class="fa fa-save"></i> Save Settings</a>
	</div>
</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {

	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');
	  });
	
	jQuery(".essb-composer-settings").click(function(e) {
		e.preventDefault();	

		var dataPosition = jQuery(this).attr('data-position') || '',
			dataPositionElement = jQuery(this).attr('data-position-element') || '';

		if (dataPosition == '' && dataPositionElement != '') 
			if (jQuery('#' + dataPositionElement).length)
				dataPosition = jQuery('#' + dataPositionElement).val();

		if (dataPosition == 'content_nativeshare')
			dataPosition = 'bottom';
		if (dataPosition == 'content_sharenative')
			dataPosition = 'top';
		
		if (dataPosition == '' || dataPosition == 'shortcode' || dataPosition == 'manual' || dataPosition == 'content_manual') {
			swal('', 'The selected option does not support customization', 'warning');
			return false;
		}

		if (dataPosition == 'content_both' || dataPosition == 'content_floatboth') {
			if (dataPosition == 'content_both') {
				//alert('The location you choose is content top & bottom. To personalize appearance of buttons you can use the inline customize button or change here to top/bottom and than press the same button again');
				swal({
					  title: "Choose top or bottom display you will customize",
					  text: "The position your currently use on site support dual display - top and bottom. Please choose which of them you will customize.",
					  type: "warning",
					  showCancelButton: true,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "Top",
					  cancelButtonText: "Bottom",
					  closeOnConfirm: true,
					  closeOnCancel: true
					},
					function(isConfirm){
					  if (isConfirm) {
						  essbLiveCustomizer.request('livecustomizer_options', { 'position': 'top', 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
					  } else {
						  essbLiveCustomizer.request('livecustomizer_options', { 'position': 'bottom', 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
					  }
					});				
			}
			if (dataPosition == 'content_floatboth') {
				//alert('The location you choose is content float from top & bottom. To personalize appearance of buttons you can use the inline customize button or change here to float from top/bottom and than press the same button again');				
				swal({
					  title: "Choose top floating or bottom display you will customize",
					  text: "The position your currently use on site support dual display - floating top and bottom. Please choose which of them you will customize.",
					  type: "warning",
					  showCancelButton: true,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "Floating Top",
					  cancelButtonText: "Bottom",
					  closeOnConfirm: true,
					  closeOnCancel: true
					},
					function(isConfirm){
					  if (isConfirm) {
						  essbLiveCustomizer.request('livecustomizer_options', { 'position': 'float', 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
					  } else {
						  essbLiveCustomizer.request('livecustomizer_options', { 'position': 'bottom', 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
					  }
					});				
}
			return;
		}

		if (debugMode)
			console.log('calling position settings = ' + dataPosition);

		essbLiveCustomizer.request('livecustomizer_options', { 'position': dataPosition, 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
	});
}
		
</script>