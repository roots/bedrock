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

$onmedia_state = in_array ( 'onmedia', $button_positions ) ? true : false;
$mobile_state = essb_option_value('mobile_positions');
$share_optimization_state = (essb_options_bool_value('opengraph_tags') || essb_options_bool_value('twitter_card')) ? true: false;
$analytics_state = essb_options_bool_value('stats_active');
$aftershare_state = essb_options_bool_value('afterclose_active');
$widget_state = in_array ( 'widget', $button_positions ) ? true : false;

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

function essb_feature_configure_button($url_configure = '') {
	return '<a href="' . $url_configure . '" class="essb-welcome-button"><i class="ti-settings"></i>Configure</a>';
}

?>

<style type="text/css">
.essb-dash-widget {
	background: #fff;
	width: 480px;
	height: 310px;
	overflow: hidden;
	float: left;
	margin-right: 20px;
	margin-bottom: 20px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	display: block;
	position: relative;
}

.essb-dash-doublewidget {
	width: 980px;
}

.essb-dash-fullwidget {
	width: 100%;
	max-width: 1480px;
}

.essb-dash-title-wrap {
	line-height: 63px;
	border-bottom: 1px solid #e5e5e5;
	border-bottom: 1px solid rgba(0, 0, 0, 0.1);
	padding: 0px 20px;
}

.essb-dash-widget-inner {
	padding: 30px 20px 20px;
	position: relative;
	max-height: 246px;
	min-height: 246px;
	width: 100%;
	overflow: hidden;
	font-size: 13px;
	font-weight: 400;
	line-height: 17px;
	position: relative;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	color: #444;
}

.essb-dash-doublewidget .essb-dash-widget-inner {
	width: 488px;
	display: inline-block;
}

.essb-dash-bottom-wrapper {
	position: absolute;
	bottom: 20px;
	left: 20px;
	width: 100%;
}

.essb-dash-title-button {
	font-weight: 600;
	border-radius: 4px;
	padding: 0px 15px;
	line-height: 32px;
	color: #fff;
	font-size: 13px;
	position: absolute;
	right: 20px;
	top: 16px;
}

.essb-dash-title {
	font-size: 19px;
	line-height: 32px;
	vertical-align: middle;
	display: inline-block;
	font-weight: 600;
	position: relative;
	z-index: 1;
}

.essb-dash-button {
	font-weight: 600;
	border-radius: 4px;
	padding: 0px 15px;
	line-height: 32px;
	color: #fff;
	font-size: 13px;
	display: inline-block;
}

.essb-dash-button-small {
	padding: 0px 15px;
	line-height: 26px;
}

.essb-dash-widget-nomargin {
	margin: 0px;
	padding: 0px;
}

.essb-dash-widget-nomargin img {
	width: 300px;
	margin: 0px !important;
}

.essb-dash-button,.essb-dash-button:hover,.essb-dash-button:visited,.essb-dash-button:focus
	{
	color: #fff;
	text-decoration: none;
	outline: none;
	box-shadow: none;
	cursor: pointer;
}

.essb-dash-grey {
	background: #D4D4D4;
}

.essb-dash-blue {
	background: #3498db;
}

.essb-dash-blue:hover {
	background: #2c8ac8;
}

.essb-small-features {
	margin-top: 10px;
}
</style>

<div class="essb-options">
	<div class="essb-options-container">

		<div class="essb-feature-row">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title">
					<i class="ti-sharethis"
						style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Social
					Sharing
				</div>
				<a
					href="<?php echo admin_url('admin.php?page=essb_options&tab=social');?>"
					class="essb-dash-title-button essb-dash-button essb-dash-blue"> <i
					class="fa fa-gear"></i> Configure Networks
				</a>

			</div>

			<div class="essb-small-features">
				<div
					class="essb-small-feature <?php echo essb_feature_class($position_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-layout"></i>
					</div>
					<div class="essb-small-content">
						<h4>Button Positions</h4>
						<span
							class="status <?php echo essb_feature_class($position_state); ?>"><?php if (!$position_state) { echo 'NOT RUNNING'; } else { echo $position_count.' POSITIONS'; }?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
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
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
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
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
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
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
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
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
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
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
				</div>

				<div
					class="essb-small-feature <?php essb_feature_class($widget_state); ?>">

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
		</div>
		
		<div class="essb-feature-row">
		<div class="essb-dash-title-wrap">
				<div class="essb-dash-title">
					<i class="ti-panel"
						style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Plugin Components
				</div>
				

			</div>
			
			<div class="essb-small-features">
				<div
					class="essb-small-feature <?php echo essb_feature_class($position_state); ?>">

					<div class="essb-small-icon">
						<i class="ti-layout"></i>
					</div>
					<div class="essb-small-content">
						<h4>Button Positions</h4>
						<span
							class="status <?php echo essb_feature_class($position_state); ?>"><?php if (!$position_state) { echo 'NOT RUNNING'; } else { echo $position_count.' POSITIONS'; }?> </span>
						<div class="essb-small-button">
						<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="essb-feature-row">
			<div class="essb-feature ">
				<div class="essb-top">
					<span class="status running">RUNNING</span>
					<h4>Social Sharing</h4>
					<div class="essb-feature-icon">
						<i class="ti-sharethis"></i>
					</div>
				</div>
				<div class="essb-bottom">
				<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_options&tab=social')); ?>
				</div>
			</div>

			<div class="essb-feature">
				<div class="essb-top">
					<span
						class="status <?php echo essb_feature_class($position_state); ?>"><?php if (!$position_state) { echo 'NOT RUNNING'; } else { echo $position_count.' POSITIONS'; }?> </span>
					<h4>Button Positions</h4>
					<div class="essb-feature-icon">
						<i class="ti-layout"></i>
					</div>
				</div>
				<div class="essb-bottom">
				<?php echo essb_feature_configure_button(admin_url('admin.php?page=essb_redirect_where&tab=where&section=display')); ?>
				<a
						href="<?php echo admin_url('admin.php?page=essb_redirect_advanced&tab=advanced&section=deactivate'); ?>"
						class="essb-welcome-button float-right"><i class="ti-close"></i>Deactivate</a>

				</div>
			</div>


			<div class="essb-feature">
				<div class="essb-top">
					<span
						class="status <?php echo essb_feature_class($onmedia_state); ?>"><?php echo essb_feature_text($onmedia_state); ?></span>
					<h4>Image Sharing</h4>
					<div class="essb-feature-icon">
						<i class="ti-image"></i>
					</div>
				</div>
				<div class="essb-bottom">
					<a href="#" class="essb-welcome-button"><i class="ti-settings"></i>
						Configure</a>
				<?php echo essb_feature_activation_button($onmedia_state); ?>
			
			</div>
			</div>

			<div class="essb-feature">
				<div class="essb-top">
					<span class="status running">RUNNING</span>
					<h4>Mobile Setup</h4>
					<div class="essb-feature-icon">
						<i class="ti-mobile"></i>
					</div>
				</div>
				<div class="essb-bottom">Bottom part</div>
			</div>

			<div class="essb-feature">
				<div class="essb-top">
					<span class="status running">RUNNING</span>
					<h4>Share Optimization</h4>
					<div class="essb-feature-icon">
						<i class="ti-new-window"></i>
					</div>
				</div>
				<div class="essb-bottom">Bottom part</div>
			</div>

			<div class="essb-feature">
				<div class="essb-top">
					<span class="status running">RUNNING</span>
					<h4>Analytics</h4>
					<div class="essb-feature-icon">
						<i class="ti-stats-up"></i>
					</div>
				</div>
				<div class="essb-bottom">Bottom part</div>
			</div>

			<div class="essb-feature">
				<div class="essb-top">
					<span class="status running">RUNNING</span>
					<h4>After Share Actions</h4>
					<div class="essb-feature-icon">
						<i class="ti-layout-cta-left"></i>
					</div>
				</div>
				<div class="essb-bottom">Bottom part</div>
			</div>

		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Plugin Optimizations</h4>
				<div class="essb-feature-icon">
					<i class="ti-rocket"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Share/Popular Widgets</h4>
				<div class="essb-feature-icon">
					<i class="ti-widget"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Opt-in Forms</h4>
				<div class="essb-feature-icon">
					<i class="ti-email"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Multilangual</h4>
				<div class="essb-feature-icon">
					<i class="ti-world"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Followers Counter</h4>
				<div class="essb-feature-icon">
					<i class="ti-heart"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Profile Links</h4>
				<div class="essb-feature-icon">
					<i class="ti-user"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Native Buttons</h4>
				<div class="essb-feature-icon">
					<i class="ti-thumb-up"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>

		<div class="essb-feature">
			<div class="essb-top">
				<span class="status running">RUNNING</span>
				<h4>Personalize</h4>
				<div class="essb-feature-icon">
					<i class="ti-palette"></i>
				</div>
			</div>
			<div class="essb-bottom">Bottom part</div>
		</div>
	</div>

</div>
