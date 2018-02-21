<?php

$tabs = array ("essb-welcome" => "What's New", "essb-promote" => "Promote & Earn Money" );
$active_tab = isset ( $_REQUEST ['tab'] ) ? $_REQUEST ['tab'] : "essb-welcome";
$slug = "essb_about";

$deactivate_appscreo = essb_options_bool_value('deactivate_appscreo');
if (ESSB3_ADDONS_ACTIVE && !$deactivate_appscreo) {
	/*if (class_exists('ESSBAddonsHelper')) {
		$addons = ESSBAddonsHelper::get_instance();
		$addons->call_remove_addon_list_update();
		if (class_exists('ESSBAdminActivate')) {
			ESSBAdminActivate::notice_new_addons();
		}
	}*/
}

?>

<div class="wrap essb-page-welcome about-wrap">
	<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress %s', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

	<div class="about-text">
		<?php _e( 'Easy Social Share Buttons for WordPress is all-in-one social share solution that allows you share, monitor and increase your social popularity by AppsCreo', 'essb' )?>
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?>
	</div>
	<div class="essb-page-actions">


		<div class="essb-welcome-button-container">
			<a
				href="<?php echo esc_attr( admin_url( 'admin.php?page=essb_options' ) ) ?>"
				class="essb-btn"><?php _e( 'Settings', 'essb' ) ?></a>
			<a href="http://codecanyon.net/downloads" target="_blank" class="essb-btn essb-btn-orange">Rate <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> Easy Social Share Buttons for WordPress</a>
		</div>
		<div class="essb-welcome-button-container">
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
			<div class="essb-welcome-button-container essb-welcome-button-container-facebook">
			<div class="fb-like" style="top: 6px; margin-left:-25px;" data-href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
			<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/bg_BG/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
			</div>
	</div>

	<!-- tabs -->
	<h2 class="nav-tab-wrapper">
	<?php foreach ( $tabs as $tab_slug => $title ): ?>
		<?php $url = 'admin.php?page=' . rawurlencode( $slug ) . '&tab=' . rawurlencode( $tab_slug ); ?>
		<a
			href="<?php echo esc_attr( is_network_admin() ? network_admin_url( $url ) : admin_url( $url ) ) ?>"
			class="nav-tab<?php echo $active_tab === $tab_slug ? esc_attr( ' nav-tab-active' ) : '' ?>">
			<?php echo $title?>
		</a>
	<?php endforeach; ?>
	</h2>

	<?php
	if ($active_tab == "essb-welcome") {
		?>
	<!-- welcome content -->
	<div class="essb_welcome-tab changelog">
		<div class="feature-section col">
			<div>
				<img class="essb-featured-img"
					src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/welcome/focus-screenshot.png" />

				<h3>Hello Easy Social Share Buttons 4.0 "Revolution"</h3>
				<h4 style="text-transform: uppercase">Unparallaled Visual Experience</h4>
				<ul>
					<li style="list-style-type: disc;"><b>19 new templates</b> included</li>
					<li style="list-style-type: disc;">new button styles & layouts</li>
					<li style="list-style-type: disc;">over <b>35 ready made presents</b> that you can apply with single click to selected location</li>
					<li style="list-style-type: disc;">new multipurpose <b>Share</b> button</li>
					<li style="list-style-type: disc;">brand new admin dashboard with real time preview</li>
					<li style="list-style-type: disc;">extremly light and fast</li>
				</ul>
				
				
				</div>
		</div>

		<div class="essb_welcome-feature feature-section col three-col">
			<div>
				<img class="essb-img-center" title=""
					src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/welcome/welcome-features-01.png" />
				<h4>New Social Networks</h4>

				<p>
				With version 4 of Easy Social Share Buttons for WordPress we extend the list of social networks by adding <b>Skype</b>, <b>Facebook Messenger</b>, <b>Kakao Story</b> and <b>Share button</b>. The brand new share button is unique in its possibilities (more button on steroids). 
				</p>
				<p>
				Whant to try the new Share Button - we prepare few ready made presents that you can easy apply for quick start.
				</p>
				</div>
			<div>
				<img class="essb-img-center" title=""
					src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/welcome/welcome-features-02.png" />
				<h4>Multilanguage Admin Interface</h4>

				<p>We made version 4 admin panel translatable. Help us make Easy Social Share Buttons speak your language. Contact us <a href="http://support.creoworx.com/contact/" target="_blank">http://support.creoworx.com/contact/</a> to provide source file and instructions.</p>
			</div>
			<div class="last-feature">
				<img class="essb-img-center" title=""
					src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/welcome/welcome-features-03.png" />
				<h4>Cool new updates under the hood</h4>

				<p>Brand new easy to use plugin settings screen with live previews. We simplify the initial setup with adding more than 35 ready made presents that you can apply to selected location.</p>
				<p>This along with more than 100 other improvements under the hood make Easy Social Share Buttons the fast and light build we have ever made.</p>
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

	</div>
	<?php
	}
	
	if ($active_tab == "essb-promote") {
		?>
	<div class="essb-page-promote changelog">
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
	<?php
	}
	?>
</div>

<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

