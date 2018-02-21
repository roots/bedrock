<?php
$button_positions = essb_option_value ( 'button_position' );
$content_positions = essb_option_value ( 'content_position' );

$position_count = 0;

if (is_array ( $button_positions )) {
	$position_count = count ( $button_positions );
}
if ($content_positions != 'shortcode') {
	$position_count ++;
}

$position_state = ($position_count > 0) ? true : false;

if (! is_array ( $button_positions )) {
	$button_positions = array ();
}

$networks = essb_option_value ( 'networks' );
if (! is_array ( $networks )) {
	$networks = array ();
}
$networks_state = (count ( $networks ) > 0) ? true : false;

$onmedia_state = in_array ( 'onmedia', $button_positions ) ? true : false;
$mobile_state = essb_option_value ( 'mobile_positions' );
$share_optimization_state = (essb_options_bool_value ( 'opengraph_tags' ) || essb_options_bool_value ( 'twitter_card' )) ? true : false;
$analytics_state = essb_options_bool_value ( 'stats_active' );
$aftershare_state = essb_options_bool_value ( 'afterclose_active' );
$widget_state = in_array ( 'widget', $button_positions ) ? true : false;
$optimization_state = true;
$optin_state = essb_option_bool_value ( 'subscribe_widget' );
$follower_state = essb_option_bool_value ( 'fanscounter_active' );
$profile_state = (essb_options_bool_value ( 'profiles_widget' ) || essb_options_bool_value ( 'profiles_display' )) ? true : false;
$native_state = essb_option_bool_value ( 'native_active' );
$shorturl_state = essb_option_bool_value ( 'shorturl_activate' );

$recovery_state = essb_option_bool_value ( 'counter_recover_active' );
$customizer_state = essb_option_bool_value ( 'customizer_is_active' );
$activation_state = ESSBActivationManager::isActivated ();

$cct_state = !essb_option_bool_value('deactivate_ctt');

function essb_feature_class($state) {
	return $state ? 'running' : 'notrunning';
}

function essb_feature_text($state) {
	return $state ? 'RUNNING' : 'NOT RUNNING';
}

function essb_feature_activation_button($feature, $state) {
	$button_icon = $state ? 'ti-close' : 'ti-control-play';
	$button_text = $state ? 'Deactivate' : 'Activate';
	
	return '<a href="#" class="essb-welcome-button essb-feature-state" data-feature="'.$feature.'" data-state="'.($state ? 'true' : 'false').'" title="'.$button_text.'"><i class="' . $button_icon . '"></i>' . '' . '</a>';
}


function essb_feature_configure_button($url_configure = '', $custom_text = '') {
	
	if ($custom_text == '') {
		$custom_text = 'Configure';
	}
	
	return '<a href="' . $url_configure . '" class="essb-welcome-button" target="_blank" title="'.$custom_text.'"><i class="ti-settings"></i>' . '' . '</a>';
}

?>

<style type="text/css">
.essb-wrap-welcome .essb-small-features {
	text-align: center;
	margin-top: 20px;
	 -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.essb-wrap-welcome .essb-small-feature {
	display: inline-block;
	width: 150px;
	margin-right: 12px;
	margin-bottom: 12px;
	padding: 15px;
	border: 1px solid rgba(0, 0, 0, 0.1);
	position: relative;
	text-align: center;
	border-radius: 4px;
	-webkit-border-radius: 4px;
	box-sizing: content-box;
}

.essb-wrap-welcome .essb-small-feature.running {
	border: 1px solid #2B6A94;
	background-color: #2B6A94;
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#2b6a94+1,23577a+100 */
	background: #2b6a94; /* Old browsers */
	background: -moz-linear-gradient(top, #2b6a94 1%, #23577a 100%);
	/* FF3.6-15 */
	background: -webkit-linear-gradient(top, #2b6a94 1%, #23577a 100%);
	/* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, #2b6a94 1%, #23577a 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient(  startColorstr='#2b6a94',
		endColorstr='#23577a', GradientType=0 ); /* IE6-9 */
	color: #fff !important;
}

.essb-wrap-welcome .essb-small-feature.running .essb-small-content h4
	{
	color: #fff;
}

.essb-wrap-welcome .essb-small-feature.running .essb-welcome-button:hover
	{
	background-color: #1ABC9C;
	color: #fff;
}

.essb-wrap-welcome .essb-small-feature.running .essb-welcome-button {
	color: #2B6A94;
	background-color: #fff;
}

.essb-wrap-welcome .essb-small-feature .essb-small-icon {
	width: 150px;
	height: 60px;
	position: relative;
}

.essb-wrap-welcome .essb-small-feature .essb-small-icon i {
	font-size: 28px;
	position: absolute;
	margin-top: -8px;
	margin-left: -14px;
	top: 50%;
	left: 50%;
}

.essb-wrap-welcome .essb-small-feature .essb-small-content {
	
}

.essb-wrap-welcome .essb-small-feature .essb-small-content h4
	{
	font-size: 13px;
	text-transform: uppercase;
	margin: 0;
	font-weight: bold;
	margin-bottom: 10px;
	letter-spacing: 0px;
}

.essb-wrap-welcome .essb-small-feature .status {
	margin-top: 5px;
	margin-bottom: 5px;
	border-radius: 4px;
	padding: 2px 5px;
	font-size: 10px;
	font-weight: bold;
	text-transform: uppercase;
	display: block;
	position: absolute;
	top: 0px;
	right: 5px;
}

.essb-wrap-welcome .essb-small-feature .status.running {
	background-color: #27AE60;
	color: #fff;
}

.essb-wrap-welcome .essb-small-feature .status.notrunning {
	background-color: #999;
	color: #fff;
}

.essb-wrap-welcome .essb-small-feature .essb-small-button,.essb-wrap-welcome .essb-small-feature .essb-small-button a
	{
	display: block;
}

.essb-wrap-welcome .essb-welcome-button {
	background-color: #2B6A94;
	color: #fff;
	text-transform: uppercase;
	font-size: 16px;
	padding: 5px;
	line-height: 24px;
	text-decoration: none;
	font-weight: 700;
	border-radius: 5px;
}

.essb-wrap-welcome .essb-welcome-button:hover,.essb-wrap-welcome .essb-feature:hover .essb-welcome-button:hover
	{
	background-color: #1ABC9C;
	color: #fff;
}

.essb-wrap-welcome .essb-feature:hover .essb-welcome-button {
	color: #2B6A94;
	background-color: #fff;
}

.essb-wrap-welcome .essb-small-feature .essb-small-content h4 {
	margin-bottom: 10px;
}

.essb-wrap-welcome .essb-small-feature .essb-welcome-button i {
	/*margin-right: 5px;*/
}
.essb-small-button.has-activate a.essb-welcome-button {
	width: 30%;
	display: inline-block;
}
</style>

<div class="section-modules">
	<div class="essb-wrap-welcome">

		<!-- On Media -->
<div
					class="essb-small-feature <?php echo essb_feature_class($onmedia_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-image"></i>
					</div>
					<div class="essb-small-content">
						<h4>On Media</h4>
						<span
							class="status <?php echo essb_feature_class($onmedia_state); ?>"><?php echo essb_feature_text($onmedia_state); ?> </span>
					</div>
					<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('onmedia', $onmedia_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display&subsection=display-13')); ?>
						</div>
				</div>
				
				<!-- Share Optimization -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($share_optimization_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-new-window"></i>
					</div>
					<div class="essb-small-content">
						<h4>Share Optmization</h4>
						<span
							class="status <?php echo essb_feature_class($share_optimization_state); ?>"><?php echo essb_feature_text($share_optimization_state); ?> </span>
						<div class="essb-small-button  has-activate">
						<?php echo essb_feature_activation_button('share_optmize', $share_optimization_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=optimize-7')); ?>
						</div>
					</div>
				</div>
				
				<!-- Analytics -->
					<div
					class="essb-small-feature <?php echo essb_feature_class($analytics_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-stats-up"></i>
					</div>
					<div class="essb-small-content">
						<h4>Analytics</h4>
						<span
							class="status <?php echo essb_feature_class($analytics_state); ?>"><?php echo essb_feature_text($analytics_state);?></span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('analytics', $analytics_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=analytics-6')); ?>
						</div>
					</div>
				</div>
				
				<!-- After Share Actions -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($aftershare_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-layout-cta-left"></i>
					</div>
					<div class="essb-small-content">
						<h4>After Share Actions</h4>
						<span
							class="status <?php echo essb_feature_class($aftershare_state); ?>"><?php echo essb_feature_text($aftershare_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('aftershare', $aftershare_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=after-share')); ?>
						</div>
					</div>
				</div>
				
				<!--  Short URL -->
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($shorturl_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-cut"></i>
					</div>
					<div class="essb-small-content">
						<h4>Short URLs</h4>
						<span
							class="status <?php echo essb_feature_class($shorturl_state); ?>"><?php echo essb_feature_text($shorturl_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('shorturl', $shorturl_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=shorturl')); ?>
						</div>
					</div>
				</div>
				
				
				<!-- Advanced Widgets -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($widget_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-widget"></i>
					</div>
					<div class="essb-small-content">
						<h4>Advanced Widgets</h4>
						<span
							class="status <?php echo essb_feature_class($widget_state); ?>"><?php echo essb_feature_text($widget_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('widget', $widget_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
				</div>
			
			
			<!-- Optin forms -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($optin_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-email"></i>
					</div>
					<div class="essb-small-content">
						<h4>Opt-in Forms</h4>
						<span
							class="status <?php echo essb_feature_class($optin_state); ?>"><?php echo essb_feature_text($optin_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('optin', $optin_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_optin&tab=optin')); ?>
						</div>
					</div>
				</div>
				
				<!-- Followers Counter -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($follower_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-heart"></i>
					</div>
					<div class="essb-small-content">
						<h4>Followers Counter</h4>
						<span
							class="status <?php echo essb_feature_class($follower_state); ?>"><?php echo essb_feature_text($follower_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('followers', $follower_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=follow')); ?>
						</div>
					</div>
				</div>
				
				<!-- Social Profiles -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($profile_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-user"></i>
					</div>
					<div class="essb-small-content">
						<h4>Profile Links</h4>
						<span
							class="status <?php echo essb_feature_class($profile_state); ?>"><?php echo essb_feature_text($profile_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('profiles', $profile_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=profiles')); ?>
						</div>
					</div>
				</div>
				
				<!-- Native Buttons -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($native_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-thumb-up"></i>
					</div>
					<div class="essb-small-content">
						<h4>Native Buttons</h4>
						<span
							class="status <?php echo essb_feature_class($native_state); ?>"><?php echo essb_feature_text($native_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('native', $native_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=native')); ?>
						</div>
					</div>
				</div>
				
				<!-- Share Recovery -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($recovery_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-share"></i>
					</div>
					<div class="essb-small-content">
						<h4>Share Recovery</h4>
						<span
							class="status <?php echo essb_feature_class($recovery_state); ?>"><?php echo essb_feature_text($recovery_state); ?> </span>
						<div class="essb-small-button has-activate">
						<?php echo essb_feature_activation_button('recovery', $recovery_state); ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_advanced&tab=advanced&section=counterrecovery')); ?>
						</div>
					</div>
				</div>
				
				<!-- Style Customizations -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($customizer_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-palette"></i>
					</div>
					<div class="essb-small-content">
						<h4>Template Customizer</h4>
						<span
							class="status <?php echo essb_feature_class($customizer_state); ?>"><?php echo essb_feature_text($customizer_state); ?> </span>
						<div class="essb-small-button">
						
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_style&tab=style')); ?>
						</div>
					</div>
				</div>
				
				<!-- Click to Tweet -->
				<div
					class="essb-small-feature <?php echo essb_feature_class($cct_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-twitter"></i>
					</div>
					<div class="essb-small-content">
						<h4>Sharable Quotes</h4>
						<span
							class="status <?php echo essb_feature_class($cct_state); ?>"><?php echo essb_feature_text($cct_state); ?> </span>
						<div class="essb-small-button">
						
						<?php echo essb_feature_activation_button('cct', $cct_state); ?>
						</div>
					</div>
				</div>
	</div>
</div>
<script type="text/javascript">
function essbLiveCustomizerPostLoad() {
	var position = jQuery('#position').val();
	jQuery( ".essb-feature-state" ).click(function(e) {
		e.preventDefault();
		
		var currentState = jQuery(this).attr('data-state') || '',
			currentFeature = jQuery(this).attr('data-feature') || '';


		// determine required action to execute
		if (currentState == 'false') {
			// activate module
			jQuery(this).attr('data-state', 'true');
			jQuery(this).closest('.essb-small-feature').removeClass('notrunning');
			jQuery(this).closest('.essb-small-feature').addClass('running');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').removeClass('notrunning');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').addClass('running');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').text('running');

			jQuery(this).attr('title', 'Deactivate');
			jQuery(this).find('i').removeClass('ti-control-play');
			jQuery(this).find('i').addClass('ti-close');
		}

		if (currentState == 'true') {
			// activate module
			jQuery(this).attr('data-state', 'false');
			jQuery(this).closest('.essb-small-feature').addClass('notrunning');
			jQuery(this).closest('.essb-small-feature').removeClass('running');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').addClass('notrunning');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').removeClass('running');
			jQuery(this).closest('.essb-small-feature').find('.essb-small-content span').text('not running');

			jQuery(this).attr('title', 'Activate');
			jQuery(this).find('i').addClass('ti-control-play');
			jQuery(this).find('i').removeClass('ti-close');
		}

		var options = { 'feature': currentFeature, 'command': (currentState == 'false') ? 'activate' : 'deactivate' };
		essbLiveCustomizer.request('livecustomizer_module', options);
		
	});

}

</script>