<?php
if (!function_exists('let_to_num')) {
	function let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
}

?>

<style type="text/css">
.essb-support {
	text-align: center;
}

.essb-firsttime-button {
	font-weight: 600;
	border-radius: 4px;
	padding: 0px 25px;
	line-height: 40px;
	color: #fff;
	font-size: 14px;
	display: inline-block;
	text-decoration: none;
	cursor: pointer;
}

.essb-firsttime-button-default {
	background-color: #3498db;
}

.essb-firsttime-button-default:hover,.essb-firsttime-button-default:active,.essb-firsttime-button-default:focus
	{
	background-color: #2c8ac8;
	color: #fff;
	text-decoration: none !important;
}

.essb-firsttime-button-color1 {
	background-color: #BB3658;
}

.essb-firsttime-button-color2 {
	background-color: #FD5B03;
}

.essb-firsttime-button-color3 {
	background-color: #2ebf99;
}

.essb-firsttime-button-color1:hover,.essb-firsttime-button-color1:active,.essb-firsttime-button-color1:focus
	{
	background-color: #7E3661;
	color: #fff;
	text-decoration: none !important;
}

.essb-firsttime-button-color2:hover,.essb-firsttime-button-color2:active,.essb-firsttime-button-color2:focus
	{
	background-color: #F04903;
	color: #fff;
	text-decoration: none !important;
}

.essb-firsttime-button-transparent {
	text-decoration: underline;
}

.essb-firsttime-button-transparent:hover,.essb-firsttime-button-transparent:focus,.essb-firsttime-button-transparent:active
	{
	color: #fff;
	text-decoration: none;
}

.essb-firsttime-button-color3:hover,.essb-firsttime-button-color3:active,.essb-firsttime-button-color3:focus
	{
	background-color: #27a483;
	color: #fff;
	text-decoration: none !important;
}

.essb-firsttime-button-transparent2 {
	text-decoration: underline;
	color: #000;
}

.essb-firsttime-button-transparent2:hover,.essb-firsttime-button-transparent2:focus,.essb-firsttime-button-transparent2:active
	{
	color: #000;
	text-decoration: none;
}

.essb-support-wrap {
	padding: 30px;
}

.support-head {
	padding: 30px;
	background: #f5f7f9;
	font-size: 17px;
	line-height: 1.6em;
	margin-bottom: 30px;
}

.support-head p {
	font-size: 16px;
	line-height: 1.5em;
}

.support-head .essb-support {
	margin-top: 30px;
}

.support-head .essb-support a {
	margin-right: 20px;
}

.essb-support-wrap .description {
	font-style: italic;
}

.about-wrap {
	max-width: 1500px;
}

.about-wrap .wp-badge {
	right: 20px;
}

.essb-welcome {
	margin-top: 30px;
}

.about-wrap h1 {
	font-size: 24px;
	font-weight: 600;
	letter-spacing: 0;
}

.about-wrap img {
	border: 0px;
}

.about-wrap .about-text {
	margin: 1em 180px 1em 0;
	font-size: 15px;
}

.about-wrap .wp-badge {
	padding-top: 70px;
	width: 100px;
	background-size: 48px;
	background-position: center 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
}

.essb-version {
	background: rgba(0, 0, 0, 0.3);
	display: block;
	position: absolute;
	padding: 10px 0px;
	width: 100%;
	bottom: 0;
	left: 0;
}

 mark.error {
	color: #a00;
	background: 0;
 	font-weight: bold;
}

 mark.yes {
	color: #7ad03a;
	background: 0;
 	font-weight: bold;
}

mark.message {
	background: 0;
	font-weight: bold;
}

mark.warning {
	background: 0;
	font-weight: bold;
	color: #FD5B03;
}

.system-status-ok {
	background: #7ad03a;
	font-weight: 600;
	color: #fff;
	text-transform: uppercase;
	padding: 3px 5px;
	border-radius: 4px;
}
.system-status-error {
	background: #a00;
	font-weight: 600;
	color: #fff;
	text-transform: uppercase;
	padding: 3px 5px;
	border-radius: 4px;
}
.system-status-warning {
	background: #FD5B03;
	font-weight: 600;
	color: #fff;
	text-transform: uppercase;
	padding: 3px 5px;
	border-radius: 4px;
}
.system-status, .system-status td { font-size: 13px; }
.system-status td { padding: 5px 0px; }

.faq .essb-portlet { border: 0px; border-bottom: 1px solid rgba(0,0,0,0.2); box-shadow: none; -webkit-box-shadow: none; }
.faq .essb-portlet .essb-portlet-heading h3 { font-size: 15px; text-transform: none; }
</style>
<div class="essb-support-wrap about-wrap ">
	<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Thank you for choosing Easy Social Share Buttons for WordPress. We are honored and are fully dedicated to making your experience perfect.', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<span class="essb-version"><?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?></span>
	</div>
	<div class="row">
		<div style="width: 60%; display: inline-block; vertical-align: top;">
			<div class="support-head">
				<p>
					Easy Social Share Buttons for WordPress comes with 6 months of free
					support for every license you purchase. Support can be <a
						href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support"
						target="_blank">extended through subscriptions</a> via CodeCanyon.
					All support for Easy Social Share Buttons for WordPress is handled
					through our <a href="http://support.creoworx.com" target="_blank">support
						center on our company site</a>. To access it, you must first setup
					an account and verify your purchase code. If you are not sure where
					you purchase code is located <a
						href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-"
						target="_blank">you can read here how to find it</a>.
				</p>
				<p>
					Access to our support system is limited to all direct customers of
					plugin. If the plugin version you are using is bundled inside theme
					you can <a href="https://socialsharingplugin.com/contact-us/"
						target="_blank">use this form to contact us</a>. Priority support
					is reserved for direct customers only. You can read more about <a
						href="https://socialsharingplugin.com/direct-customer-benefits/"
						target="_blank">direct customer benefirts here</a>.
				</p>

				<div class="essb-support">
					<a href="http://support.creoworx.com" target="_blank"
						class="essb-firsttime-button essb-firsttime-button-default">Go To
						Support System</a> <a href="https://docs.socialsharingplugin.com" target="_blank"
						class="essb-firsttime-button essb-firsttime-button-color1">Visit
						Knowledge Base</a>
				</div>
			</div>
		</div>
		<div style="width:calc(40% - 60px); padding: 10px 25px; display: inline-block; vertical-align: top;">
			<h3 style="margin-top: 0;">System Status</h3>
			
			<?php 
			$remote_get_status = '';
			$remote_post_status = '';
			
			$response = wp_safe_remote_get( 'https://build.envato.com/api/', array( 'decompress' => false, 'user-agent' => 'passionblogger-remote-get-test' ) );
			$remote_get_status = ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<span class="system-status-ok">OK</span>' : '<span class="system-status-error">FAIL</span>';
			
			$response = wp_safe_remote_post( 'https://envato.com/', array( 'decompress' => false, 'user-agent' => 'passionblogger-remote-get-test' ) );
			$remote_post_status = ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<span class="system-status-ok">OK</span>' : '<span class="system-status-error">FAIL</span>';
						
			if (function_exists ( 'curl_version' )) {
				$curl_version = curl_version ();
				$curl_status = '<span class="system-status-ok">OK</mark>';
			} else {
				$curl_status = '<span class="system-status-error">Disabled</mark>';
			}
			$theme = wp_get_theme ();
			
			$time_limit = ini_get( 'max_execution_time' );
			
			if ( 60 > $time_limit && 0 != $time_limit ) {
				$time_limit = '<span class="system-status-error">' . $time_limit . '</span>';
			} else {
				$time_limit = '<span class="system-status-ok">' . $time_limit . '</span>';
			}
			
			$memory = let_to_num( WP_MEMORY_LIMIT );
			if ( $memory < 64000000 ) {
				$memory = '<span class="system-status-error">' . size_format($memory) . '</span>';
			} 
			else if ( $memory < 96000000 ) {
				$memory = '<span class="system-status-warning">' . size_format($memory) . '</span>';
			}
			else {
				$memory = '<span class="system-status-ok">' . size_format($memory) . '</span>';
			}
			
			$max_input_vars = ini_get( 'max_input_vars' );
			if ($max_input_vars < 1000) {
				$max_input_vars = '<span class="system-status-error">' . $max_input_vars . '</span>';				
			}
			if ($max_input_vars > 999 && $max_input_vars < 3000) {
				$max_input_vars = '<span class="system-status-warning">' . $max_input_vars . '</span>';	
				$max_input_vars .= '<br/><span class="description">Current value of max input vars may prevent some options to save - for example in Where to display section. If you face such problem we recommend to increase value at setup 5000 or deactive display methods and functions from Plugin Functions menu.</span>';
			}
			if ($max_input_vars > 2999) {
				$max_input_vars = '<span class="system-status-ok">' . $max_input_vars . '</span>';
			}
			
			
			$system_status = '
			<table style="width:100%; margin-top: 20px;" cellspacing="0" cellpadding="3" border="0" class="system-status">
			<col width="60%"/><col width="40%"/>
			<tr class="even table-border-bottom"><td><b>WordPress Version</b></td><td>' . get_bloginfo ( 'version' ) . '</td></tr>
			<tr class="odd table-border-bottom"><td><b>PHP Version</b></td><td>' . phpversion () . '</td></tr>
			<tr class="odd table-border-bottom"><td><b>WP Memory Limit</b></td><td>' . $memory . '</td></tr>
			<tr class="even table-border-bottom"><td><b>PHP Time Limit</b></td><td>' . $time_limit . '</td></tr>
			<tr class="odd table-border-bottom"><td><b>Max Input Vars</b></td><td>' . $max_input_vars . '</td></tr>
			<tr class="odd table-border-bottom"><td><b>cURL</b></td><td>' . $curl_status . '</td></tr>
			<tr class="even table-border-bottom"><td><b>WP Remote Get</b></td><td>' . $remote_get_status . '</td></tr>
			<tr class="odd table-border-bottom"><td><b>WP Remote Post</b></td><td>' . $remote_post_status . '</td></tr>
			</table>
			';
			
			echo $system_status;
				
			?>
			
			<p style="text-align: center;">
			<a href="<?php echo admin_url('admin.php?page=essb_redirect_status&tab=status'); ?>"
						class="essb-firsttime-button essb-firsttime-button-transparent2">Visit System Status Page</a>
			</p>
		</div>
	</div>

	
	<div class="faq essb-options-container">
		<h3>FAQ</h3>
	
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to activate plugin?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>Activation of plugin will give you access to <a href="https://socialsharingplugin.com/direct-customer-benefits/" target="_blank">direct customer benefits</a> including automatic updates, access to extensions libarary, access to ready made styles and many more.</p>
		<p>To activate plugin visit <a href="<?php echo admin_url('admin.php?page=essb_redirect_update&tab=update');?>">Activation screen</a> and fill your purchase code. You can learn how to find your purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">here</a>. A step by step tutorail you can find inside our knowledge base for <a href="https://docs.socialsharingplugin.com/activate-easy-social-share-buttons/" target="_blank"><b>How to activate Easy Social Share Buttons</b></a>.</p>
		<p>Only versions of plugin that are purchased directly can be activated. All versions that are bundled inside theme will show a theme activated message but you cannot get access to direct customer benefits unless you purchase a direct plugin copy from us.</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to activate/deactivate Ready Made Styles?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>Ready made styles allow to load preset configuration of plugin to a selected from you location. Activation of ready made styles will set personalized location based settings and since then global settings will not affect this location. <a href="https://docs.socialsharingplugin.com/activatedeactivate-ready-made-styles-easy-social-share-buttons/" target="_blank">Read here how to Activate/Deactivate ready made styles</a> on your site.
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to activate debug mode of WordPress?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>If for some reason you get a white screen on your site to find the cause you need to activate debug mode of WordPress. Debug mode will change that white screen to a message we can understand and navigate you to solve the problem. To activate mode <a href="https://docs.socialsharingplugin.com/activate-debug-mode-wordpress/" target="_blank"> follow this steps in our knowledge base</a>.</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
				<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to make manual plugin update?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>If you need to manually update plugin here are the steps you need to complete:</p>.
		<ol>
			<li>Go to your Plugins screen and find current version of Easy Social Share Buttons for WordPress</li>
			<li>Deactivate and then Delete the existing installation</li>
			<li>Install the new version using WordPress plugin installer or via FTP</li>
		</ol>
		<p>All your settings will be saved and you will not loose them during manual plugin update</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to deactivate additional social share optimization tags when Yoast SEO plugin is used?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>To optimize and control shared information over social networks we generate and set on site social share optimization tags. It is very important to have only one instance of those tags on your site - having more than one may cause a problem in sharing or loosing control over custom share data you set. If you use Yoast SEO plugin on your site and come in such situation <a href="https://docs.socialsharingplugin.com/disable-yoast-seo-social-share-optimization-tags-generation/" target="_blank"> read here is what you need to do</a>.</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to deactivate frontend setup module?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>Easy Social Share Buttons for WordPress comes with active by default frontend assistant (Customize button on each instance of buttons and the blue icon at the bottom right corner). That assistant is visible for admin users only but if you wish to deactivate it please <a href="https://docs.socialsharingplugin.com/deactivate-frontend-assistant/" target="_blank"> read here</a>.</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		
		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to activate share recovery when moved from http to https?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>If you recently move your site from http to https you may see a sudden counter removal. That is caused because social networks count all shares using URL as unique key and switching protocol is also changing that. To restore back your shares here are the steps you need to do:</p>
		<ol>
			<li>Ensure that your counter update mode is not set to Real time. To do this go to Social Sharing -> Share Counter Setup and on the update counter field you should see anything different than real time.</li>
			<li>Inside Social Sharing -> Share Counter Setup activate share counter recovery and set a cause of change to be Change of protocol from http to https</li>
			<li>If you expereince problem with Facebook counter please try the all 3 different API update points by changing one by one from Social Sharing -> Share Counter Setup -> Single Button Counter</li>
		</ol>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>

		<?php 
		echo ESSBOptionsFramework::draw_panel_start('How to activate fake share counters?', '', 'fa32 fa fa-question', array('mode' =>'toggle', 'state' => 'closed'));
		?>
		<p>Fake share counters (internal counters) can be easy activated with a setting inside plugin. Once switched ON all social network counters will start track shares internally (by click over share button). To do this visit Plugin Functions menu and under developer tools activate Fake (internal) share counters. Once that is done you will be able to control share counter value on each post and you will also see a new menu Developer Tools which you can use to setup minimal fake counter value for all posts.</p>
		<p>Change of generated share counters is also available via hooks and filters. If you are developer you can <a href="https://docs.socialsharingplugin.com/create-dummy-fake-share-counters/" target="_blank">read here how to do it</a>.</p>
		<?php 
		echo ESSBOptionsFramework::draw_panel_end();
		?>
		</div>
<div class="essb-support">
	<p>For more frequently asked questions, useful tutorials and guides please visit our blog or read knowledge base.</p>
					<a href="https://appscreo.com" target="_blank"
						class="essb-firsttime-button essb-firsttime-button-default">Read Our Blog</a> <a href="https://docs.socialsharingplugin.com" target="_blank"
						class="essb-firsttime-button essb-firsttime-button-color1">Visit
						Knowledge Base</a>
				</div>
</div>
