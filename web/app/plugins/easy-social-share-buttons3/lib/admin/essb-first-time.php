<?php 
update_option(ESSB3_FIRST_TIME_NAME, 'false');
?>
<div class="wrap essb-page-welcome about-wrap">
	<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Easy Social Share Buttons for WordPress is all-in-one social share solution that allows you share, monitor and increase your social popularity by AppsCreo', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?>
	</div>

	<!-- welcome content -->
	<div class="essb_welcome-tab changelog">

		<div class="essb_welcome-feature feature-section col three-col">
			<h3>Congratulations! You are runing Easy Social Share Buttons for
				first time.</h3>
			<span></span>
			<div>
				<span class="essb-firsttime-center"> <i
					class="fa fa-bolt fa-lg essb-firsttime-icon"></i>
					<h4>Quick setup wizard</h4>
				</span>
				<p>Quick setup wizard is a great way to make a quick work through
					plugin settings and make initial plugin setup.</p>
				
			</div>
			<div>
				<span class="essb-firsttime-center"> <i
					class="fa fa-send fa-lg essb-firsttime-icon"></i>
					<h4>Start with ready made styles</h4>
				</span>

				<p>We hand pick and configure most popular ready made styles that
					you can import and customize</p>
				
			</div>
			<div class="last-feature">
				<span class="essb-firsttime-center"> <i
					class="fa fa-check-square-o fa-lg essb-firsttime-icon"></i>
					<h4>Continue to plugin settings</h4>
				</span>

				<p>Don't know where to start? Continue and explore plugin settings. Quick setup wizard or ready made styles can be started at any time.</p>
				
			</div>
			<div><p align="center">
					<a
						href="<?php echo esc_attr( admin_url( 'admin.php?page=essb_redirect_quick&tab=quick' ) ) ?>"
						class="essb-btn essb-btn-orange" style="width: 95%; text-align: center;"><?php _e( 'Start quick setup wizard', 'essb' ) ?></a>
				</p></div>
			<div><p align="center">
					<a
						href="<?php echo esc_attr( admin_url( 'admin.php?page=essb_redirect_import&tab=import&section=readymade' ) ) ?>"
						class="essb-btn essb-btn-green" style="width: 95%; text-align: center;"><?php _e( 'Go to ready made style library', 'essb' ) ?></a>
				</p></div>
			<div class="last-feature"><p align="center">
					<a
						href="<?php echo esc_attr( admin_url( 'admin.php?page=essb_options' ) ) ?>"
						class="essb-btn essb-btn-red" style="width: 95%; text-align: center; margin-bottom: 10px;"><?php _e( 'Continue to plugin settings', 'essb' ) ?></a>
				</p></div>
		</div>



		<p class="essb-thank-you">
			Thank you for choosing <b>Easy Social Share Buttons for WordPress</b>.
			If you like our work please <a href="http://codecanyon.net/downloads"
				target="_blank">rate Easy Social Share Buttons for WordPress <i
				class="fa fa-star"></i><i class="fa fa-star"></i><i
				class="fa fa-star"></i><i class="fa fa-star"></i><i
				class="fa fa-star"></i></a>
		</p>

	</div>

</div>

