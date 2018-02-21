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

$networks = essb_option_value('networks');
if (!is_array($networks)) {
	$networks = array();
}
$networks_state = (count($networks) > 0) ? true : false;

$onmedia_state = in_array ( 'onmedia', $button_positions ) ? true : false;
$mobile_state = essb_option_value ( 'mobile_positions' );
$share_optimization_state = (essb_options_bool_value ( 'opengraph_tags' ) || essb_options_bool_value ( 'twitter_card' )) ? true : false;
$analytics_state = essb_options_bool_value ( 'stats_active' );
$aftershare_state = essb_options_bool_value ( 'afterclose_active' );
$widget_state = in_array ( 'widget', $button_positions ) ? true : false;
$optimization_state = true;
$optin_state = essb_option_bool_value('subscribe_widget');
$follower_state = essb_option_bool_value('fanscounter_active');
$profile_state = (essb_options_bool_value('profiles_widget') || essb_options_bool_value('profiles_display')) ? true : false;
$native_state = essb_option_bool_value('native_active');
$shorturl_state = essb_option_bool_value('shorturl_activate');

$recovery_state = essb_option_bool_value('counter_recover_active');
$customizer_state = essb_option_bool_value('customizer_is_active');
$activation_state = ESSBActivationManager::isActivated();

function essb_feature_class($state) {
	return $state ? 'running' : 'notrunning';
}

function essb_feature_text($state) {
	return $state ? 'RUNNING' : 'NOT RUNNING';
}

function essb_feature_activation_button($state, $url_activate = '', $url_deactivate = '') {
	$button_icon = $state ? 'ti-close' : 'ti-control-play';
	$button_text = $state ? 'Deactivate' : 'Activate';
	$button_url = $state ? $url_deactivate : $url_activate;
	
	return '<a href="' . $button_url . '" class="essb-welcome-button"><i class="' . $button_icon . '"></i>' . $button_text . '</a>';
}

function essb_feature_configure_button($url_configure = '', $custom_text = '') {
	
	if ($custom_text == '') { $custom_text = 'Configure'; }
	
	return '<a href="' . $url_configure . '" class="essb-welcome-button"><i class="ti-settings"></i>'.$custom_text.'</a>';
}

?>

<style type="text/css">

.essb-version {
	background: rgba(0, 0, 0, 0.3);
	display: block;
	position: absolute;
	padding: 5px 0px;
	width: 100%;
	bottom: 0;
	left: 0;
	font-size: 12px;
	text-transform: uppercase;
}

.essb-page-welcome .wp-badge {
	padding-top: 70px;
	width: 100px;
	background-size: 48px;
	background-position: center 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
}

.about-wrap { max-width: 1500px; }
.about-wrap .wp-badge { right: 20px; }

.essb-welcome { margin-top: 10px; }

.essb-welcome-close { margin-bottom: 1em; }

.about-wrap h1 { font-size: 24px; font-weight: 600; }
.about-wrap .about-text { margin: 1em 180px 0 0; font-size: 16px; }


.essb-dash-widget 				{	background:#fff; width:480px; overflow: hidden; float:left; margin-right:20px; margin-bottom:20px;box-sizing: border-box;-moz-box-sizing: border-box; display: block; position: relative;}

.essb-dash-doublewidget 		 	{	width:980px;}
.essb-dash-fullwidget 		 	{	width:100%; max-width: 1480px; }

.essb-dash-halffullwidget { width: 48%; max-width: 920px; }

@media (max-width: 1260px) {
	.essb-dash-halffullwidget { width: 98%; }
}

.essb-dash-title-wrap 		 	{	line-height:43px; border-bottom:1px solid #e5e5e5;  border-bottom:1px solid rgba(0,0,0,0.1); padding:0px 20px;}
.essb-dash-widget-inner 			{	padding:30px 20px 20px;position: relative;width:100%;overflow: hidden; font-size:13px; font-weight: 400; line-height: 17px; position: relative;box-sizing: border-box;-moz-box-sizing: border-box; color:#444;}
.essb-dash-doublewidget .essb-dash-widget-inner { width:488px; display: inline-block;}
.essb-dash-bottom-wrapper	{	position: absolute;bottom:20px;left:20px;width:100%;}
.essb-dash-title-button 	{	font-weight:600;border-radius: 4px; padding:0px 15px; line-height: 32px; color:#fff; font-size:13px; position: absolute;right:20px;top:16px;}
.essb-dash-title 			{	font-size:13px; line-height:32px; vertical-align: middle; display: inline-block;font-weight:700;position: relative;z-index: 1; text-transform: uppercase; letter-spacing: 1px; }

.essb-dash-button 	{	font-weight:600;border-radius: 4px; padding:0px 15px; line-height: 32px; color:#fff; font-size:13px; display: inline-block;}

.essb-dash-button-small { padding: 0px 15px; line-height: 26px;  }

.essb-dash-widget-nomargin { margin: 0px; padding: 0px; }
.essb-dash-widget-nomargin img { width: 300px; margin: 0px !important; }
.essb-dash-button, .essb-dash-button:hover, .essb-dash-button:visited, .essb-dash-button:focus {
	color: #fff;
	text-decoration: none;
	outline: none;
	box-shadow: none;
	cursor: pointer;
}

.essb-dash-grey { background: #D4D4D4; }

.essb-dash-blue { background: #3498db; }
.essb-dash-blue:hover { background: #2c8ac8; }

.essb-dash-widget-scroll {
	overflow-y: scroll;
}

.essb-c-red {
	color: #e74c3c;
}
.essb-bg-red {
	background: #e74c3c;
}

a.essb-bg-red:hover {
	background: #d62c1a;
}

.essb-c-green {
	color: #27ae60;
}

.essb-bg-green {
	background: #27ae60;
}

.essb-feature-icon, .essb-feature-text {
	display: inline-block;
}

.essb-feature-text b, .essb-feature-text span {
	display: block;
	
}

.essb-feature-icon i {
	font-size: 30px;
	margin-right: 10px;
}

.essb-dash-feature {
	margin-bottom: 15px;
}

.essb-dash-feature.essb-dash-feature-extension {
	margin-bottom: 5px;
}

.essb-free { background-color: #27AE60; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 4px; font-size: 10px; font-weight: bold; }
.essb-paid { background-color: #D33257; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 4px; font-size: 10px; font-weight: bold; }
.essb-fnew { background-color: #1abc9c; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 6px; font-size: 10px; font-weight: bold; }
.essb-fupdate { background-color: #2980b9; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 6px; font-size: 10px; font-weight: bold; }
.essb-ffix { background-color: #7f8c8d; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 6px; font-size: 10px; font-weight: bold; }

.essb-fnew, .essb-fupdate, .essb-ffix {
	text-transform: uppercase;
	margin-right: 5px;
}

.essb-free, .essb-paid {
	padding: 2px 6px;
	float: right;
}

.essb-bg-orange { 
	background: #FF7416;
}

.essb-dash-featureimage { 
	display: inline-block;
	width: 300px;
	margin-right: 30px;
}

.essb-dash-featurecol {
	width: 450px;
	display: inline-block;
	margin: 0px 20px;
	vertical-align: top;
}

.essb-dash-featurecol ul, .essb-dash-featurecol li {
	list-style: none;
	font-weight: 600;
}

.essb-welcome-quick-access .essb-btn i {
	display: block;
	font-size: 24px;
	line-height: 32px;
	margin-bottom: 5px;
}

.essb-welcome-quick-access .essb-btn {
	text-align: center;
	width:15.8%;
	margin-bottom: 10px;
}

</style>

<div class="wrap essb-page-welcome about-wrap essb-wrap-welcome">
	<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Thank you for choosing the best social sharing plugin for WordPress. You are about to use most powerful social media plugin for WordPress ever - get ready to increase your social shares, followers and mail list subscribers. We hope you enjoy it!', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<span class="essb-version"><?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?></span>
	</div>
	
	<div class="essb-welcome-close">
		<a
					href="<?php echo admin_url('admin.php?page=essb_redirect_social&tab=social&dismiss-welcome=true');?>"
					class=" essb-dash-button essb-dash-blue"> <i
					class="fa fa-close"></i> Do not show again welcome screen
				</a>
	</div>
	
	<div class="essb-welcome-quick-access">
	
	<?php echo '<a href="https://appscreo.com" target="_blank" text="' . __ ( 'Read useful articles in our blog', 'essb' ) . '" class="essb-btn float_right"><i class="fa fa-rss"></i>&nbsp;' . __ ( 'Tips & Tricks', 'essb' ) . '</a>'; ?>
	<?php echo '<a href="'.admin_url ("admin.php?page=essb_redirect_status").'"  text="' . __ ( 'Check System Status', 'essb' ) . '" class="essb-btn essb-btn-red" style="margin-right: 5px;"><i class="fa fa-file-text-o"></i>&nbsp;' . __ ( 'Check System Status', 'essb' ) . '</a>'; ?>
	<?php if (ESSB3_ADDONS_ACTIVE) { ?>
		<?php echo '<a href="'.admin_url ("admin.php?page=essb_addons").'"  text="' . __ ( 'Extensions', 'essb' ) . '" class="essb-btn essb-btn-orange" style="margin-right: 5px;"><i class="fa fa-gear"></i>&nbsp;' . __ ( 'Extensions', 'essb' ) . '</a>'; ?>
	<?php  } ?>
	<?php echo '<a href="'.admin_url ("admin.php?page=essb_redirect_quick&tab=quick").'"  text="' . __ ( 'Quick Setup Wizard', 'essb' ) . '" class="essb-btn essb-btn-red" style="margin-right: 5px;"><i class="fa fa-bolt"></i>&nbsp;' . __ ( 'Quick Setup Wizard', 'essb' ) . '</a>'; ?>
	<?php echo '<a href="'.admin_url ("admin.php?page=essb_redirect_readymade&tab=readymade").'"  text="' . __ ( 'Ready Made Styles', 'essb' ) . '" class="essb-btn essb-btn-green" style="margin-right: 5px;"><i class="fa fa-bolt"></i>&nbsp;' . __ ( 'Apply Ready Made Styles', 'essb' ) . '</a>'; ?>
	<?php echo '<a href="http://support.creoworx.com" target="_blank" text="' . __ ( 'Need Help? Click here to visit our support center', 'essb' ) . '" class="essb-btn float_right"><i class="fa fa-question"></i>&nbsp;' . __ ( 'Get Support', 'essb' ) . '</a>'; ?>
	
	</div>
	
	<!-- new welcome screen -->
	<div class="essb-welcome">
	
		<div class="essb-dash-widget essb-dash-halffullwidget">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="ti-sharethis" style="margin-right: 5px; font-size: 16px; float: left; line-height: 32px;"></i>Social Sharing</div>
				
			</div>
			<div class="essb-dash-widget-inner essb-dash-widget-nomargin">
				<!-- Social Sharing Wrap -->
				
				<div class="essb-small-features">
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($networks_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-sharethis"></i>
					</div>
					<div class="essb-small-content">
						<h4>Social Networks</h4>
						
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social')); ?>
						</div>
					</div>
					<span
							class="status <?php echo essb_feature_class($networks_state); ?>"><?php if (!$networks_state) { echo 'NO NETWORKS'; } else { echo count($networks).' NETWORKS'; }?> </span>
				</div>
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($position_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-layout"></i>
					</div>
					<div class="essb-small-content">
						<h4>Button Positions</h4>
						
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
					<span
							class="status <?php echo essb_feature_class($position_state); ?>"><?php if (!$position_state) { echo 'NOT RUNNING'; } else { echo $position_count.' POSITIONS'; }?> </span>
				</div>

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
					<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display&subsection=display-13')); ?>
						</div>
				</div>

				<div
					class="essb-small-feature <?php echo essb_feature_class($mobile_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-mobile"></i>
					</div>
					<div class="essb-small-content">
						<h4>Mobile Setup</h4>
						<span
							class="status <?php echo essb_feature_class($mobile_state); ?>"><?php echo essb_feature_text($mobile_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=mobile')); ?>
						</div>
					</div>
				</div>

				<div
					class="essb-small-feature <?php echo essb_feature_class($share_optimization_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-new-window"></i>
					</div>
					<div class="essb-small-content">
						<h4>Share Optmization</h4>
						<span
							class="status <?php echo essb_feature_class($share_optimization_state); ?>"><?php echo essb_feature_text($share_optimization_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=optimize-7')); ?>
						</div>
					</div>
				</div>

				<div
					class="essb-small-feature <?php echo essb_feature_class($analytics_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-stats-up"></i>
					</div>
					<div class="essb-small-content">
						<h4>Analytics</h4>
						<span
							class="status <?php echo essb_feature_class($analytics_state); ?>"><?php echo essb_feature_text($analytics_state);?></span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=analytics-6')); ?>
						</div>
					</div>
				</div>

				<div
					class="essb-small-feature <?php echo essb_feature_class($aftershare_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-layout-cta-left"></i>
					</div>
					<div class="essb-small-content">
						<h4>After Share Actions</h4>
						<span
							class="status <?php echo essb_feature_class($aftershare_state); ?>"><?php echo essb_feature_text($aftershare_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=after-share')); ?>
						</div>
					</div>
				</div>

				<div
					class="essb-small-feature <?php echo essb_feature_class($shorturl_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-cut"></i>
					</div>
					<div class="essb-small-content">
						<h4>Short URLs</h4>
						<span
							class="status <?php echo essb_feature_class($shorturl_state); ?>"><?php echo essb_feature_text($shorturl_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_social&section=shorturl')); ?>
						</div>
					</div>
				</div>
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($widget_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-widget"></i>
					</div>
					<div class="essb-small-content">
						<h4>Advanced Widgets</h4>
						<span
							class="status <?php echo essb_feature_class($widget_state); ?>"><?php echo essb_feature_text($widget_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
				</div>
			</div>
				
				
				<!-- end: Social Sharing Wrap -->
			</div>
		</div>
		
		<div class="essb-dash-widget essb-dash-halffullwidget">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="ti-package" style="margin-right: 5px; font-size: 16px; float: left; line-height: 32px;"></i>Modules</div>
				</a>
			</div>
			<div class="essb-dash-widget-inner essb-dash-widget-nomargin">
			
				<!-- Other Functions -->
							<div class="essb-small-features">
				<div
					class="essb-small-feature <?php echo essb_feature_class($optimization_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-rocket"></i>
					</div>
					<div class="essb-small-content">
						<h4>Optimizations</h4>
						<span
							class="status <?php echo essb_feature_class($optimization_state); ?>"><?php echo essb_feature_text($optimization_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_advanced&tab=advanced')); ?>
						</div>
					</div>
				</div>
				
								<div
					class="essb-small-feature <?php echo essb_feature_class($optin_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-email"></i>
					</div>
					<div class="essb-small-content">
						<h4>Opt-in Forms</h4>
						<span
							class="status <?php echo essb_feature_class($optin_state); ?>"><?php echo essb_feature_text($optin_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_optin&tab=optin')); ?>
						</div>
					</div>
				</div>
				
						<div
					class="essb-small-feature <?php echo essb_feature_class($follower_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-heart"></i>
					</div>
					<div class="essb-small-content">
						<h4>Followers Counter</h4>
						<span
							class="status <?php echo essb_feature_class($follower_state); ?>"><?php echo essb_feature_text($follower_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=follow')); ?>
						</div>
					</div>
				</div>
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($profile_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-user"></i>
					</div>
					<div class="essb-small-content">
						<h4>Profile Links</h4>
						<span
							class="status <?php echo essb_feature_class($profile_state); ?>"><?php echo essb_feature_text($profile_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=profiles')); ?>
						</div>
					</div>
				</div>

								<div
					class="essb-small-feature <?php echo essb_feature_class($native_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-thumb-up"></i>
					</div>
					<div class="essb-small-content">
						<h4>Native Buttons</h4>
						<span
							class="status <?php echo essb_feature_class($native_state); ?>"><?php echo essb_feature_text($native_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_display&tab=display&section=native')); ?>
						</div>
					</div>
				</div>
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($recovery_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-share"></i>
					</div>
					<div class="essb-small-content">
						<h4>Share Recovery</h4>
						<span
							class="status <?php echo essb_feature_class($recovery_state); ?>"><?php echo essb_feature_text($recovery_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_advanced&tab=advanced&section=counterrecovery')); ?>
						</div>
					</div>
				</div>
				
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
				
				<div
					class="essb-small-feature <?php echo essb_feature_class($activation_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-lock"></i>
					</div>
					<div class="essb-small-content">
						<h4>Activation</h4>
						<span
							class="status <?php echo essb_feature_class($activation_state); ?>"><?php echo ($activation_state) ? 'activated' : 'not activated'; ?> </span>
						<div class="essb-small-button">
						<?php if ($activation_state):?>
						<div style="visibility: hidden;">
						<?php endif; ?>
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_style&tab=style')); ?>
						<?php if ($activation_state):?>
						</div>
						<?php endif; ?>
						</div>
					</div>
				</div>
				
				<div
					class="essb-small-feature">

					<div class="essb-small-icon">
						<i class="ti-close"></i>
					</div>
					<div class="essb-small-content">
						<h4>Deactivate Modules</h4>
						<span style="visibility: hidden; "
							class="status <?php echo essb_feature_class($native_state); ?>"><?php echo essb_feature_text($native_state); ?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_update&tab=update', 'Activate')); ?>
						</div>
					</div>
				</div>
			</div>
				
			<!-- end: Other Functions -->
			</div>
		</div>
	</div>
</div>


