<?php
/**
 * Display information for post share counters
 */

?>

<?php 
if (!class_exists('ESSBLiveCustomizerControls')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}


global $post_id;
$custom = get_post_custom ( $post_id );
$listOfNetworks = essb_available_social_networks();

$counter_mode = essb_option_value('counter_mode');

$social_proof_enable = essb_option_value('social_proof_enable');
$button_counter_hidden_till = essb_option_value('button_counter_hidden_till');
$total_counter_hidden_till = essb_option_value('total_counter_hidden_till');

// draw custom network information
?>

<div class="section-counters">
	<div class="customizer-inner-title"><span>Share Counters Setup</span></div>

	<div class="row field">
		Counters Update Mode
	</div>
	<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_select_field('counter_mode', 'options', $counter_mode, essb_cached_counters_update());
		?>
	</div>
	<div class="row description">
		Customize period of counters update. We recommend usage of real time share counters only in development mode because sending too many calls to social API may lead missing share counter for a few hours of the day.
	</div>

	<div class="row field">
		Cache plugin/server compatible mode
	</div>
	<div class="row param">
		<?php 
		//cache_counter_refresh_cache
		ESSBLiveCustomizerControls::draw_switch_field2('cache_counter_refresh_cache', essb_option_value('cache_counter_refresh_cache'), 'options', 'cache_counter_refresh_cache');
		?>
	</div>
	<div class="row description">
		This option is required when you use cache plugin on your site to allow counters update at background even when page is cached. All updated counters will appear on site once cache is fully updated (for most cache plugins this happes automatically once a hour or once a day).
	</div>

	<div class="row field">
		Speed up process of counters update
	</div>
	<div class="row param">
		<?php 
		//cache_counter_refresh_cache
		ESSBLiveCustomizerControls::draw_switch_field2('cache_counter_refresh_async', essb_option_value('cache_counter_refresh_async'), 'options', 'cache_counter_refresh_async');
		?>
	</div>
	<div class="row description">
		This option will activate asynchronous counter update mode which is up to 5 times faster than regular update. Option requires to have PHP 5.4 or newer.
	</div>
	
	
	<div class="row field">
		Avoid Social Negative Proof
	</div>
	<div class="row param">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('social_proof_enable', $social_proof_enable, 'options', 'social_proof_enable');
		?>
	</div>
	<div class="row description">
		Activate this option if you wish to make your share counters invisible till you reach set from you value of shares. This helps to encourage shares on new posts avoiding negative social proof.
	</div>
	
	<div class="avoid-negative-proof subsection" <?php if ($social_proof_enable == '') { echo 'style="display: none;"'; } ?>>
		<div class="row field">
			Individual Share Button
		</div>
		<div class="row param">
			<input type="text" class="section-save" name="button_counter_hidden_till" data-update="options" data-field="button_counter_hidden_till" value="<?php echo $button_counter_hidden_till; ?>" placeholder="ex. 1" />
		</div>
		<div class="row description">
			Set share value for individual button
		</div>
	
		<div class="row field">
			Total Share Counter
		</div>
		<div class="row param">
			<input type="text" class="section-save" name="total_counter_hidden_till" data-update="options" data-field="total_counter_hidden_till" value="<?php echo $total_counter_hidden_till; ?>" placeholder="ex. 1" />
		</div>
		<div class="row description">
			Set share value for individual button
		</div>
	
		
	</div>
	<div class="row">
		<a href="#" class="essb-composer-button essb-composer-blue essb-section-save" data-section="section-counters"><i class="fa fa-save"></i> Save Settings</a>
	</div>
	
	<?php if ($counter_mode != ''): ?>
	<div class="customizer-inner-title"><span>Share Counter Values for: <?php echo get_the_title($post_id);?></span></div>
	<div class="row description">
		Displayed blocks below provide information for all stored by social networks counter values. Those values will result of any configuration you have and all buttons that you have active accross differnt devices. If you wish to remove the entire counter history for this post press the button below - Clear Counter History. The Clear Counter History will remove all stored values by social networks and it will also setup immediate share counter update.
	</div>
	
	<?php 
	echo '<div class="row">';
	foreach ($listOfNetworks as $key => $data) {
		$value = isset ( $custom ["essb_c_".$key] ) ? $custom ["essb_c_".$key] [0] : "";
	
		if (intval($value) != 0) {
			echo '<div class="counter-panel">';
			echo '  <div class="counter-icon">';
			echo '     <i class="essb_icon_'.$key.'"></i>';
			echo '  </div>';
			echo '  <div class="counter-details">';
			echo '     <div class="network-name">';
			echo $data["name"];
			echo '     </div>';
			echo '     <div class="counter-value">';
			echo '     '.$value;
			echo '     </div>';
			echo '  </div>';
			echo '</div>';
		}
	}
	echo '</div>';
	$essb_cache_expire = isset ( $custom ['essb_cache_expire'] ) ? $custom ['essb_cache_expire'] [0] : "";
	
	echo '<div class="counter-update-message">';
	
	if ($essb_cache_expire != '') {
		echo 'Next counter update will be at '.date(DATE_RFC822, $essb_cache_expire);
	}
	else {
		echo 'Counter update information is not available';
	}
	
	echo '</div>';
	
	echo '<div class="row counter-update-button">';
	echo '<a href="'.get_permalink($post_id).'?essb_counter_update=true" class="essb-composer-button essb-composer-blue"><i class="fa fa-refresh"></i> Update Counters</a>';
	echo '</div>';
	echo '<div class="row counter-update-button">';
	echo '<a href="'.get_permalink($post_id).'?essb_clear_cached_counters=true" class="essb-composer-button essb-composer-blue"><i class="fa fa-refresh"></i> Update Counters for Entire Site</a>';
	echo '</div>';
	echo '<div class="row counter-update-button">';
	echo '<a href="'.get_permalink($post_id).'?essb_clear_counters_history=true" class="essb-composer-button essb-composer-red"><i class="fa fa-refresh"></i> Clear Counter History & Update Counters</a>';
	echo '</div>';
	?>
	
	<?php endif; ?>

</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {
	jQuery(".essb-switch.social_proof_enable .cb-enable").click(function(){
		jQuery('.avoid-negative-proof').fadeIn();
	});

	jQuery(".essb-switch.social_proof_enable .cb-disable").click(function(){
		jQuery('.avoid-negative-proof').fadeOut();
	});

	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');

	    if (jQuery(this).hasClass('social_proof_enable')) {
		    if (jQuery(this).hasClass('checked'))
		    	jQuery('.avoid-negative-proof').fadeIn();
		    else
		    	jQuery('.avoid-negative-proof').fadeOut();
	    }
	  });
}
		
</script>