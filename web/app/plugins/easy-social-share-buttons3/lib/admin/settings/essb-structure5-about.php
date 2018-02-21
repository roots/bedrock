<?php

$tabs = array ("essb-welcome" => "What's New", "essb-promote" => "Promote & Earn Money" );
$active_tab = isset ( $_REQUEST ['tab'] ) ? $_REQUEST ['tab'] : "essb-welcome";
$slug = "essb_about";



?>
<!--  sweet alerts -->
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.css">

<style type="text/css">

#mce-EMAIL { background-color: #d9d9d9; border: 0px; padding: 8px !important; }

.essb-tl-right { text-align: right; }

.essb-version {
	background: rgba(0, 0, 0, 0.3);
	display: block;
	position: absolute;
	padding: 10px 0px;
	width: 100%;
	bottom: 0;
	left: 0;
}

.about-wrap { max-width: 1500px; }
.about-wrap .wp-badge { right: 20px; }

.essb-welcome { margin-top: 30px; }

.about-wrap h1 { font-size: 32px; }
.about-wrap img { border: 0px; }
.about-wrap .about-text { margin: 1em 180px 1em 0; }
.essb-dash-widget 				{	background:#fff; width:48%; height:310px; overflow: hidden; float:left; margin-right:20px; margin-bottom:20px;box-sizing: border-box;-moz-box-sizing: border-box; display: block; position: relative;}
.essb-dash-shadow { box-shadow: 0 0 5px rgba(0,0,0,0.08); -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.08); }
.essb-dash-doublewidget 		 	{	width:980px;}
.essb-dash-fullwidget 		 	{	width:100%; max-width: 1480px; }

.essb-dash-title-wrap 		 	{	line-height:63px; border-bottom:1px solid #e5e5e5;  border-bottom:1px solid rgba(0,0,0,0.1); padding:0px 20px;}
.essb-dash-widget-inner 			{	padding:30px 20px 20px;position: relative;max-height:246px; min-height:246px;width:100%;overflow: hidden; font-size:13px; font-weight: 400; line-height: 17px; position: relative;box-sizing: border-box;-moz-box-sizing: border-box; color:#444;}
.essb-dash-doublewidget .essb-dash-widget-inner { width:488px; display: inline-block;}
.essb-dash-bottom-wrapper	{	position: absolute;bottom:20px;left:20px;width:100%;}
.essb-dash-title-button 	{	font-weight:600;border-radius: 4px; padding:0px 15px; line-height: 32px; color:#fff; font-size:13px; position: absolute;right:20px;top:16px;}
.essb-dash-title 			{	font-size:19px; line-height:32px; vertical-align: middle; display: inline-block;font-weight:600;position: relative;z-index: 1;}

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

.essb-page-welcome .essb-welcome-button-container {
	display: inline-block;
	margin-right: 10px;
}

.essb-page-welcome .essb-welcome-button-container.essb-welcome-button-container-google {
	position: relative;
	top: 8px;
}

.essb-welcome-button-container-twitter iframe { margin-bottom: -10px; }




</style>

<div class="wrap essb-page-welcome about-wrap">
	<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Thank you for choosing the best social sharing plugin for WordPress. You are about to use most powerful social media plugin for WordPress ever - get ready to increase your social shares, followers and mail list subscribers. We hope you enjoy it!', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<span class="essb-version"><?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?></span>
	</div>
	<div class="essb-page-actions">


		<div class="essb-welcome-button-container">
			<a href="http://codecanyon.net/downloads" target="_blank" class="essb-btn essb-btn-orange" style="margin-right: 100px;">Rate us <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></a>
		</div>

			<div class="essb-welcome-button-container essb-welcome-button-container-facebook">
			<div class="fb-like" style="top: 7px; margin-left: -70px;" data-href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
			<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
			</div>
			
					<div class="essb-welcome-button-container essb-welcome-button-container-twitter">
			<a href="https://twitter.com/share" class="twitter-share-button"
				data-text="I just install the best #socialsharing plugin for #wordpress Easy Social Share Buttons by @appscreo"
				data-url="http://bit.ly/socialsharewp" data-size="large"
				data-counturl="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476">Tweet</a>
			<script>! function ( d, s, id ) {
				var js, fjs = d.getElementsByTagName( s )[ 0 ], p = /^http:/.test( d.location ) ? 'http' : 'https';
				if ( ! d.getElementById( id ) ) {
					js = d.createElement( s );
					js.id = id;
					js.src = p + '://platform.twitter.com/widgets.js';
					fjs.parentNode.insertBefore( js, fjs );
				}
			}( document, 'script', 'twitter-wjs' );</script>
		</div>
					<div
			class="essb-welcome-button-container essb-welcome-button-container-google">

			<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone"
				data-href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476"></div>
		</div>
			
	</div>

	<!-- new welcome screen -->
	<div class="essb-welcome">
	
		<!-- widget activation -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title <?php if (ESSBActivationManager::isActivated()) { echo "essb-c-green";} else { echo "essb-c-red"; } ?>"><i class="ti-key" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Plugin Activation</div>
				<a href="<?php echo admin_url('admin.php?page=essb_redirect_update');?>" class="essb-dash-title-button essb-dash-button <?php if (ESSBActivationManager::isActivated()) { echo "essb-bg-green";} else { echo "essb-bg-red"; } ?>">
					<i class="fa <?php if (ESSBActivationManager::isActivated()) { echo "fa-check";} else { echo "fa-ban"; } ?>"></i>
					<?php if (ESSBActivationManager::isActivated()) { echo "Activated";} else { echo "Activate Plugin to Unlock"; } ?>
				</a>
				
			</div>
			<div class="essb-dash-widget-inner">
				<div class="essb-dash-feature">
					<div class="essb-feature-icon">
						<i class="ti-reload"></i>
					</div>
					<div class="essb-feature-text">
						<b>Automatic Updates</b>
						<span>Get new versions directly to your dashboard</span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-icon">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="essb-feature-text">
						<b>Ready Made Styles</b>
						<span>One click pre made styles to quick start easy</span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-icon">
						<i class="ti-package"></i>
					</div>
					<div class="essb-feature-text">
						<b>Extensions Library</b>
						<span>Exclusive add-ons for our direct buyers only</span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-icon">
						<i class="fa fa-language"></i>
					</div>
					<div class="essb-feature-text">
						<b>Multilangual Support</b>
						<span>Use WMPL or Polylang to extend sharing of your multilangual site</span>
					</div>
				</div>
			</div>
		</div>
		<!-- end: widget activate -->

		<?php 
		$current_list = array ();
		
		if (class_exists ( 'ESSBAddonsHelper' )) {
		
			$essb_addons = ESSBAddonsHelper::get_instance ();
			$current_list = $essb_addons->get_addons ();
		}
		
		
		if (! isset ( $current_list )) {
			$current_list = array ();
		}
		
		$count = 0;
		$filters_offset = 0;
		foreach ( $current_list as $addon_key => $addon_data ) {
			if ($addon_key == "filters") {
				$filters_offset = 1;
				continue;
			}

			$count++;
		}
		
		?>
		
		<!-- widget extensions -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="ti-package" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Extensions Library (<?php echo $count; ?>)</div>
				<a href="<?php echo admin_url('admin.php?page=essb_redirect_extensions&tab=extensions');?>" class="essb-dash-title-button essb-dash-button essb-dash-blue">
					<i class="fa fa-gear"></i>
					Browse All <?php echo $count; ?> Extensions
				</a>
				
			</div>
			<div class="essb-dash-widget-inner">
			
				<?php 

				
				
				$count = 0;
				$filters_offset = 0;
				foreach ( $current_list as $addon_key => $addon_data ) {			
					if ($addon_key == "filters") { 
						$filters_offset = 1; 
						continue; 
					}
					
					if ($count < 6) {
						echo '<div class="essb-dash-feature essb-dash-feature-extension">';
						echo '<div class="essb-feature-text">';
						echo '<b>'.$addon_data ["name"];
						print (($addon_data ['price'] == 'FREE') ? '<span class="essb-free">FREE</span>' : '<span class="essb-paid">'.$addon_data ['price'].'</span>' );
						echo '</b>';
						echo '</div>';
						echo '</div>';
					}
					$count++;
				}
				
				?>
							<div class="essb-dash-bottom-wrapper">
				<?php 
				
				if (!ESSBActivationManager::isActivated()) {
					echo '<div class="essb-dash-button essb-dash-grey">Activate plugin to unlock extensions library</div>';
				}
				
				?>
			</div>
				
				
			</div>
		</div>
		<!-- end: widget extensions -->
		
		<!-- widget update -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="ti-reload" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Plugin Updates</div>
				
				<?php if (ESSBActivationManager::existNewVersion()) { ?>
				<div class="essb-dash-title-button essb-dash-button essb-bg-orange">
					<i class="fa fa-refresh"></i>
					New Version Available
				</div>
				<?php } ?>
			</div>
			<div class="essb-dash-widget-inner">
				<div class="essb-dash-feature">
					
					<div class="essb-feature-text">
						<b>Installed Version</b>
						<span><?php echo ESSB3_VERSION; ?></span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-text">
						<b>Latest Version</b>
						<span>
						<?php 
						
						$latest = ESSBActivationManager::getLatestVersion();
						if ($latest == '') { $latest = ESSB3_VERSION; }
						
						if (version_compare ( $latest, ESSB3_VERSION, '<' )) {
							$latest = ESSB3_VERSION;
						}
						
						echo $latest;
						
						?>
						</span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-text">
						<a href="#" class="essb-dash-button essb-dash-blue" id="essb-check-forupdate">Check for new version</a>
					</div>
				</div>
			</div>
			<div class="essb-dash-bottom-wrapper">
				<?php 
				
				if (!ESSBActivationManager::isActivated()) {
					echo '<div class="essb-dash-button essb-dash-grey">Activate plugin to unlock automatic updates</div>';
				}
				
				?>
			</div>
		</div>
		<!-- end: widget update -->
		
		<!-- widget newsletter -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="ti-email" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>AppsCreo Newsletter</div>
			</div>
			<div class="essb-dash-widget-inner">
				<div class="essb-dash-feature">
					<div class="essb-feature-icon">
						<i class="ti-gift"></i>
					</div>
					<div class="essb-feature-text">
						<b>Free Goodies</b>
						<span>Learn for our new free goodies that we reguraly release</span>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-icon" style="vertical-align: top;">
						<i class="ti-announcement"></i>
					</div>
					<div class="essb-feature-text" style="max-width: 380px;">
						<b>News</b>
						<span>Be the first to know for what is new in social sharing or in Easy Social Share Buttons</span>
					</div>
				</div>
			</div>
			<div class="essb-dash-bottom-wrapper">
				<?php 
				
				//if (!ESSBActivationManager::isActivated()) {
				//	echo '<div class="essb-dash-button essb-dash-grey">Activate plugin to unlock automatic updates</div>';
				//}
				$code = '<div class="essb-admin-widget">';
				$code .= '<form action="//appscreo.us13.list-manage.com/subscribe/post?u=a1d01670c240536f6a70e7778&amp;id=c896311986" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';
				$code .= '<div class="" id="title-wrap" style="margin-top: 5px;">';
				//print '<label class="screen-reader-text prompt" for="mce-EMAIL" id="title-prompt-text">Enter your email</label>';
				$code .= '<input type="email" name="EMAIL" id="mce-EMAIL" autocomplete="off" placeholder="Enter your email" style="width: 250px; border-radius: 3px; font-size: 12px; padding: 3px;" />';
				$code .= '<input type="submit" name="subscribe" id="mc-embedded-subscribe" class="essb-btn" value="Subscribe" style="font-size:11px; box-shadow: none;">';
				$code .= '</div>';
				$code .= '</form>';
				$code .= '</div>';
				echo $code;
				
				?>
			</div>
		</div>
		<!-- end: widget newsletter -->
		
		<!-- widget translate -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="fa fa-language" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Translate Plugin</div>
			</div>
			<div class="essb-dash-widget-inner">
				<div class="essb-dash-feature">
					<div class="essb-feature-text">
					
					<b>Help us make Easy Social Share Buttons speak in your language</b>
							
					</div>
				</div>
				
				<div class="essb-dash-feature">
					<div class="essb-feature-text">

					<span>
					<?php echo 'Version 4 of Easy Social Share Buttons for WordPress has fully translatable admin panel. Help up us and our customers by translating plugin in your language.'; ?>
					</span>					
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-text">
					
					<b>Completed translations</b>
					</div>
				</div>
				<div class="essb-dash-feature">
					<div class="essb-feature-text">
					
					<span><div class="essb-dash-button essb-bg-orange">EN</div> <div class="essb-dash-button essb-bg-orange">FR</div> <div class="essb-dash-button essb-bg-orange">ES</div>	</span>							
					</div>
				</div>
				</div>
			<div class="essb-dash-bottom-wrapper">

								
			</div>
		</div>
		<!-- end: widget translate -->
		
		<!-- widget support -->
		<div class="essb-dash-widget essb-dash-shadow">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title"><i class="fa fa-life-ring" style="margin-right: 10px; font-size: 24px; float: left; line-height: 32px;"></i>Product Support</div>
								<?php 
				
				if (!ESSBActivationManager::isActivated()) {
					echo '<div class="essb-dash-title-button essb-dash-button essb-dash-grey">Activate plugin to unlock support</div>';
				}
				
				?>
				
			</div>
			<div class="essb-dash-widget-inner">
				<div class="essb-dash-feature essb-dash-feature-extension">
					<div class="essb-feature-icon">
						<i class="ti-info-alt"></i>
					</div>
					<div class="essb-feature-text">
						<b>Useful tips</b>
						<span>Read our blog for useful tips on how to work with plugin</span>
					</div>
				</div>
				<div class="essb-dash-feature essb-tl-right" style="margin-bottom: 0px;">
					<div class="essb-feature-text">
						<a href="http://appscreo.com/?utm_source=about&utm_campaign=panel&utm_medium=button" class="essb-dash-button essb-dash-blue essb-dash-button-small" target="_blank">Visit our blog</a>					
					</div>
				</div>
				<div class="essb-dash-feature essb-dash-feature-extension">
					<div class="essb-feature-icon">
						<i class="ti-help-alt"></i>
					</div>
					<div class="essb-feature-text">
						<b>Online Support</b>
						<span>Visit our online support system for dedicated help with plugin work</span>
						
					</div>
				</div>
				<div class="essb-dash-feature essb-tl-right"  style="margin-bottom: 0px;">
					<div class="essb-feature-text">
						<a href="http://support.creoworx.com/?utm_source=about&utm_campaign=panel&utm_medium=button" class="essb-dash-button essb-dash-blue essb-dash-button-small" target="_blank">Go to support system</a>
					</div>
				</div>
				<div class="essb-dash-feature essb-dash-feature-extension">
					<div class="essb-feature-icon">
						<i class="ti-book"></i>
					</div>
					<div class="essb-feature-text">
						<b>Knowledge Base</b>
						<span>Read our knowledge base to get know how to use most common functions</span>
					</div>
				</div>
				<div class="essb-dash-feature essb-tl-right" style="margin-bottom: 0px;">
					<div class="essb-feature-text">
						<a href="https://docs.socialsharingplugin.com/?utm_source=about&utm_campaign=panel&utm_medium=button" class="essb-dash-button essb-dash-blue essb-dash-button-small" target="_blank">Visit Knowledge Base</a>
					</div>
				</div>
			</div>
			<div class="essb-dash-bottom-wrapper">

			</div>
		</div>
		<!-- end: widget support -->
		
		<div class="essb-dash-widget essb-dash-fullwidget">
			<div class="essb-dash-title-wrap">
				<div class="essb-dash-title">What's new in version <?php echo ESSB3_VERSION; ?></div>
				<a href="http://socialsharingplugin.com/version-changes/" target="_blank" class="essb-dash-title-button essb-dash-button essb-dash-blue">
					Read the full changelog
				</a>
			</div>
			<div class="essb-dash-widget-inner essb-dash-widget-nomargin">
				
			</div>
		</div>
		
	</div>
	
	<p class="essb-thank-you">
			Thank you for choosing <b>Easy Social Share Buttons for WordPress</b>.
			If you like our work please <a href="http://codecanyon.net/downloads"
				target="_blank">rate Easy Social Share Buttons for WordPress <i
				class="fa fa-star"></i><i class="fa fa-star"></i><i
				class="fa fa-star"></i><i class="fa fa-star"></i><i
				class="fa fa-star"></i></a>
	</p>


	<div class="essb-page-promote changelog" style="display: none;">
		<div class="feature-section col">
			<div>
				<h4>
					Promote <b>Easy Social Share Buttons for WordPress</b> and earn
					money from the Envato Affiliate Program.
				</h4>
				Send traffic to any page on Envato Market while adding your account
				username to the end of the URL. When a new user clicks your referral
				link, signs up for an account and purchases an item (or deposits
				money) via any of the Envato Market sites, you will receive 30% of
				that person's first cash deposit or purchase price. If they deposit
				$20 into their account, you get $6. If they buy a $200 item, you get
				$60.
				<p>
				<a href="http://themeforest.net/make_money/affiliate_program" target="_blank">Read more about how Envato affiliate program works on its official site.</a>
				</p>
			</div>
			<p>&nbsp;</p>
			<p>
				Your Envato Username: <input type="text" class="input-element"
					name="envato-user" id="envato-user" /><a href="#"
					class="button button-primary" id="generate-my-code">Get my code</a>
			</p>

			<p id="usercode" style="display: none;">
			Example affilaite links that you can use:<br/>
				<textarea id="user-generated-code" class="input-element"
					style="width: 100%; height: 300px"></textarea>
			</p>
		</div>
	</div>
	<script type="text/javascript">

	jQuery(document).ready(function($){
		$('#generate-my-code').click(function(e) {
			e.preventDefault();

			var envatoUsername = $('#envato-user').val();

			var myCode = "";
			myCode += "<!-- Example code 1 -->\r\n";
			myCode += '<a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='+envatoUsername+'" target="_blank" title="Easy Social Share Buttons for WordPress - Social sharing plugin that will amplify your social reach">Easy Social Share Buttons for WordPress - Social sharing plugin that will amplify your social reach</a>';
			myCode += "\r\n\r\n";

			myCode += "<!-- Example code 2 -->\r\n";
			myCode += '<a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='+envatoUsername+'" target="_blank" title="Easy Social Share Buttons for WordPress">Easy Social Share Buttons for WordPress</a>';
			myCode += "\r\n\r\n";

			myCode += "<!-- Example code 3 -->\r\n";
			myCode += '<a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='+envatoUsername+'" target="_blank" title="Easy Social Share Buttons for WordPress">This site uses Easy Social Share Buttons for WordPress</a>';
			myCode += "\r\n\r\n";
			
			myCode += "<!-- Example code 4 -->\r\n";
			myCode += '<a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='+envatoUsername+'" target="_blank" title="Social Sharing Plugin for WordPress">Social Sharing Plugin for WordPress that will help increase your social presentation</a>';
			myCode += "\r\n\r\n";
			
			
			$('#user-generated-code').val(myCode);
			
			$('#usercode').show();
		});
	});

	</script>

</div>

<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<style type="text/css">
.preloader {
  position: fixed;
  width: 64px;
  height: 64px;
  border: 6px solid #fff;
  border-radius: 100%;
}
.preloader:before,
.preloader:after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -0.2rem 0 0 -0.2rem;
  border-bottom: 6px solid #fff;
  border-radius: 10px;
  -webkit-transform-origin: 3px center;
}
.preloader:before {
/* hour hand */
  width: 30%;
  -webkit-animation: hour 10s linear infinite;
}
.preloader:after {
/* minute hand */
  width: 40%;
  background-color: #2085e6;
  -webkit-animation: minute 1s linear infinite;
}
@-webkit-keyframes hour {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
@-webkit-keyframes minute {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
/* for demo purposes only — not required */
.preloader {
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

.preloader-holder {
	position: fixed;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  top: 0;
  left: 0;
}

.preloader-message {
	position: fixed;
	font-size: 32px;
	line-height: 32px;
	font-family: 'Open Sans', sans-serif;
	font-weight: bold;
	top: calc(50% + 56px);
	bottom: 0;
	left: 0;
	margin: 0;
	text-align: center;
	margin: auto;
	width: 400px;
	right: 0;
	color: #fff;
}

.preloader-holder { display: none; }
.sweet-alert h2 {
	letter-spacing: -0.5px;
	color: #303133;
	font-size: 24px;
	font-weight: 700;
}

.sweet-alert p {
	font-size: 14px;
	color: #303133;
	font-weight: 400;
}

.sweet-alert button {
	font-size: 14px;
	font-weight: 700;
}

.sweet-overlay { 
background-color: rgba(0, 0, 0, 0.7);
}
</style>

<div class="preloader-holder">
<div class="preloader"></div>
<div class="preloader-message">Please Wait a Moment ...</div>
</div>
<script type="text/javascript">

	// assign ajax submit on form
jQuery(document).ready(function($){
	if ($('#essb-check-forupdate').length) {
		$('#essb-check-forupdate').click(function(e) {
			e.preventDefault();

			$('.preloader-holder').fadeIn(100);
			var plugin_is_activated = <?php if (ESSBActivationManager::isActivated()) { echo 'true'; } else { echo 'false'; }?>;
			var version_api = '<?php echo ESSBActivationManager::getApiUrl('api')?>version.php'; 
			$.ajax({
				type: "GET",
		        url: version_api,
		        data: {},
		        success: function (data) {
		        	$('.preloader-holder').fadeOut(400);
	                console.log(data);
	                if (typeof(data) == "string")
	                	data = JSON.parse(data);
	                
	                var code = data['code'] || '';
	                var version = data['version'] || '';

	                if (code == '200') {
	                	$.ajax({
	    		            type: "POST",
	    		            url: "<?php echo admin_url("admin-ajax.php");?>",
	    		            data: { 'action': 'essb_process_activation', 'activation_state': 'version_check', 'version': version},
	    		            success: function (data) {
	    		            	console.log(data);
	    		            	 if (typeof(data) == "string")
	    			                	data = JSON.parse(data);

	 			                var code = data['code'] || '';
	 			                if (code != '') {
		 			                if (plugin_is_activated) {
		 			                	swal("New version " + code + " is available!", "Visit updates screen to proceed with plugin update", "success");
		 			                }
		 			                else {
	 			                		swal("New version " + code + " is available!", "Activate plugin to unlock automatic updates", "success");
		 			                }
	 			                }
	 			                else {
	 			                	swal("", "You are running latest version of plugin!", "");
	 			                }
	    		            }
	                	});
	                }
		        },
		        error: function() {
		        	$('.preloader-holder').fadeOut(400);
		        	swal("Connection Error!", "A problem occured when connection to update server. Please try again later or check the what is new page for our latest release", "error");
		        }
			});
		});
	}
});
	
</script>